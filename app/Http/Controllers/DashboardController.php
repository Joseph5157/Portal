<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    protected $workflowService;

    public function __construct(\App\Services\OrderWorkflowService $workflowService)
    {
        $this->workflowService = $workflowService;
    }

    public function index()
    {
        $user = auth()->user();

        // Vendor Dashboard Logic
        $stats = [
            'available_pool' => Order::where('status', 'pending')->whereNull('claimed_by')->count(),
            'active_jobs' => Order::where('status', 'processing')->where('claimed_by', $user->id)->count(),
            'total_checked_today' => Order::where('status', 'delivered')
                ->where('claimed_by', $user->id)
                ->whereDate('delivered_at', today())
                ->count(),
            'overdue_count' => Order::where('status', '!=', 'delivered')
                ->where('due_at', '<', now())
                ->count(),
        ];

        $myWorkspace = Order::with(['client', 'files', 'report', 'vendor'])
            ->where('claimed_by', $user->id)
            ->whereIn('status', ['pending', 'processing'])
            ->get();

        $availableFiles = Order::with(['client', 'files', 'vendor'])
            ->whereNull('claimed_by')
            ->where('status', 'pending')
            ->latest()
            ->get();

        $recentHistory = Order::with(['client', 'files', 'report'])
            ->where('claimed_by', $user->id)
            ->where('status', 'delivered')
            ->latest('delivered_at')
            ->take(5)
            ->get();

        $topAgents = \App\Models\User::withCount([
            'orders as jobs_count' => function ($query) {
                $query->where('status', 'delivered')
                    ->whereDate('delivered_at', today());
            }
        ])
            ->where('role', 'vendor')
            ->orderByDesc('jobs_count')
            ->take(5)
            ->get();

        return view('dashboard', compact('stats', 'myWorkspace', 'availableFiles', 'recentHistory', 'topAgents'));
    }

    protected function adminDashboard()
    {
        $stats = [
            'total_processed_today' => Order::where('status', 'delivered')
                ->whereDate('delivered_at', today())
                ->count(),
            'pending_pool' => Order::where('status', 'pending')->whereNull('claimed_by')->count(),
            'active_vendors' => \App\Models\User::where('role', 'vendor')
                ->whereHas('orders', function ($q) {
                    $q->whereDate('delivered_at', today());
                })->count(),
            'new_clients_today' => \App\Models\Client::whereDate('created_at', today())->count(),
            'total_clients' => \App\Models\Client::count(),
            'total_vendors' => \App\Models\User::where('role', 'vendor')->count(),
        ];

        $vendorPerformance = \App\Models\User::where('role', 'vendor')
            ->withCount([
                'orders as total_jobs' => function ($q) {
                    $q->where('status', 'delivered');
                }
            ])
            ->withCount([
                'orders as today_jobs' => function ($q) {
                    $q->where('status', 'delivered')->whereDate('delivered_at', today());
                }
            ])
            ->orderByDesc('today_jobs')
            ->take(10)
            ->get();

        $recentOrders = Order::with(['client', 'vendor'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'vendorPerformance', 'recentOrders'));
    }

    public function claim(Order $order)
    {
        try {
            $this->workflowService->claim($order, auth()->user());
            return back()->with('success', 'Order claimed successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate(['status' => 'required|in:processing,delivered']);

        try {
            if ($request->status === 'processing') {
                $this->workflowService->startProcessing($order, auth()->user());
            } elseif ($request->status === 'delivered') {
                $this->workflowService->deliver($order, auth()->user());
            }

            return back()->with('success', 'Status updated.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function uploadReport(Request $request, Order $order)
    {
        $request->validate([
            'report' => 'required|file|mimes:pdf|max:102400', // 100MB PDF
            'ai_percentage' => 'nullable|numeric|min:0|max:100',
            'plag_percentage' => 'nullable|numeric|min:0|max:100',
        ]);

        try {
            $path = $request->file('report')->store('reports/' . $order->id);

            $this->workflowService->uploadReport($order, auth()->user(), [
                'report_path' => $path,
                'ai_percentage' => $request->ai_percentage,
                'plag_percentage' => $request->plag_percentage,
            ]);

            // Auto-promote to processing if still pending before delivering
            if ($order->fresh()->status === 'pending') {
                $this->workflowService->startProcessing($order->fresh(), auth()->user());
            }

            // Automatically deliver after upload
            $this->workflowService->deliver($order->fresh(), auth()->user());

            return back()->with('success', 'Report uploaded and order delivered successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function downloadFile(Order $order, \App\Models\OrderFile $file)
    {
        // Only vendors/admins can download order files
        if ($file->order_id !== $order->id) {
            abort(404);
        }

        return Storage::download($file->file_path);
    }
}
