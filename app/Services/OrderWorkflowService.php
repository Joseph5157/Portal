<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderLog;
use App\Models\OrderReport;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;

class OrderWorkflowService
{
    /**
     * Claim a pending, unclaimed order.
     *
     * Rules:
     * - Order must be in 'pending' status.
     * - Order must not already be claimed.
     */
    public function claim(Order $order, User $user): void
    {
        if ($order->status !== 'pending') {
            throw new Exception("Only pending orders can be claimed. This order is '{$order->status}'.");
        }

        if ($order->claimed_by !== null) {
            throw new Exception("This order has already been claimed and is not available.");
        }

        DB::transaction(function () use ($order, $user) {
            $order->update(['claimed_by' => $user->id]);

            $this->logActivity($order, $user, 'claim', 'Order claimed by agent', null, null);
        });
    }

    /**
     * Move a pending order to processing.
     *
     * Rules:
     * - Only the claiming vendor or an admin may start processing.
     * - Order must be in 'pending' status (not already processing or delivered).
     * - Cannot start processing on a delivered order.
     */
    public function startProcessing(Order $order, User $user): void
    {
        $this->assertVendorOrAdmin($order, $user, 'start processing');

        if ($order->status === 'delivered') {
            throw new Exception("Cannot change a delivered order back to processing.");
        }

        if ($order->status !== 'pending') {
            throw new Exception("Order must be in 'pending' status to start processing. Current status: '{$order->status}'.");
        }

        DB::transaction(function () use ($order, $user) {
            $oldStatus = $order->status;
            $order->update(['status' => 'processing']);

            $this->logActivity($order, $user, 'start_processing', 'Order processing started', $oldStatus, 'processing');
        });
    }

    /**
     * Attach a report to the order and update metrics.
     *
     * Rules:
     * - Only the claiming vendor or an admin may upload a report.
     * - Cannot upload a report for an already-delivered order.
     * - report_path must be present in $data.
     */
    public function uploadReport(Order $order, User $user, array $data): void
    {
        $this->assertVendorOrAdmin($order, $user, 'upload a report for');

        if ($order->status === 'delivered') {
            throw new Exception("Cannot upload a report for an order that has already been delivered.");
        }

        if (empty($data['report_path'])) {
            throw new Exception("A report file path must be provided.");
        }

        DB::transaction(function () use ($order, $user, $data) {
            OrderReport::updateOrCreate(
                ['order_id' => $order->id],
                ['report_path' => $data['report_path']]
            );

            $order->update([
                'ai_percentage' => $data['ai_percentage'] ?? $order->ai_percentage,
                'plag_percentage' => $data['plag_percentage'] ?? $order->plag_percentage,
            ]);

            $this->logActivity($order, $user, 'upload_report', 'Report uploaded and metrics updated');
        });
    }

    /**
     * Mark an order as delivered.
     *
     * Rules:
     * - Only the claiming vendor or an admin may deliver the order.
     * - Order must be in 'processing' status.
     * - A report PDF must exist before delivery.
     * - A delivered order cannot be delivered again.
     */
    public function deliver(Order $order, User $user): void
    {
        $this->assertVendorOrAdmin($order, $user, 'deliver');

        if ($order->status === 'delivered') {
            throw new Exception("This order has already been delivered and cannot be re-delivered.");
        }

        if ($order->status !== 'processing') {
            throw new Exception("Order must be in 'processing' status before delivery. Current status: '{$order->status}'.");
        }

        // Refresh the report relationship to avoid stale cache
        if (!$order->report()->exists()) {
            throw new Exception("A report PDF must be uploaded before the order can be delivered.");
        }

        DB::transaction(function () use ($order, $user) {
            $oldStatus = $order->status;
            $order->update([
                'status' => 'delivered',
                'delivered_at' => now(),
            ]);

            $this->logActivity($order, $user, 'deliver', 'Order delivered to client', $oldStatus, 'delivered');
        });
    }

    // ─── Private Helpers ────────────────────────────────────────────────────────

    /**
     * Ensure the acting user is either the vendor who claimed the order or an admin.
     * Throws if neither condition is met.
     */
    protected function assertVendorOrAdmin(Order $order, User $user, string $action): void
    {
        $isOwner = (int) $order->claimed_by === (int) $user->id;
        $isAdmin = $user->role === 'admin';

        if (!$isOwner && !$isAdmin) {
            throw new Exception("You are not authorized to {$action} this order.");
        }
    }

    /**
     * Create an activity log entry for an order action.
     */
    protected function logActivity(
        Order $order,
        User $user,
        string $action,
        string $notes = null,
        string $oldStatus = null,
        string $newStatus = null
    ): void {
        OrderLog::create([
            'order_id' => $order->id,
            'user_id' => $user->id,
            'action' => $action,
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
            'notes' => $notes,
        ]);
    }
}
