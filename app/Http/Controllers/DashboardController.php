<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->role === 'client') {
            return redirect()->route('client.dashboard');
        }

        $stats = [
            'available_pool' => Order::where('status', 'pending')->whereNull('claimed_by')->count(),
            'active_jobs' => Order::where('status', 'processing')->where('claimed_by', auth()->id())->count(),
            'total_checked_today' => Order::where('status', 'delivered')
                ->where('claimed_by', auth()->id())
                ->whereDate('delivered_at', today())
                ->count(),
        ];

        // My Workspace (Claimed by current user and not delivered)
        $workspaceOrders = Order::with(['client', 'files', 'creator'])
            ->where('claimed_by', auth()->id())
            ->where('status', '!=', 'delivered')
            ->get();

        // Available Pool (Unclaimed pending orders)
        $poolOrders = Order::with(['client', 'files', 'creator'])
            ->whereNull('claimed_by')
            ->where('status', 'pending')
            ->latest()
            ->get();

        // Recent History (Last 5 delivered by current user)
        $recentHistory = Order::with(['client', 'files'])
            ->where('claimed_by', auth()->id())
            ->where('status', 'delivered')
            ->latest('delivered_at')
            ->take(5)
            ->get();

        // Top Agents Leaderboard
        $topAgents = \App\Models\User::withCount([
            'orders as jobs_count' => function ($query) {
                $query->where('status', 'delivered');
            }
        ])
            ->orderByDesc('jobs_count')
            ->take(5)
            ->get();

        return view('dashboard', compact('stats', 'workspaceOrders', 'poolOrders', 'recentHistory', 'topAgents'));
    }

    public function claim(Order $order)
    {
        if ($order->claimed_by && auth()->user()->role !== 'admin') {
            return back()->with('error', 'Order already claimed.');
        }

        $order->update(['claimed_by' => auth()->id()]);
        return back()->with('success', 'Order claimed successfully.');
    }

    public function updateStatus(Request $request, Order $order)
    {
        if ($order->claimed_by !== auth()->id() && auth()->user()->role !== 'admin') {
            abort(403);
        }

        $request->validate(['status' => 'required|in:processing,delivered']);

        if ($request->status == 'delivered') {
            if (!$order->report) {
                return back()->with('error', 'Cannot mark as delivered without uploading report.');
            }
            $order->update([
                'status' => 'delivered',
                'delivered_at' => now()
            ]);
        } else {
            $order->update(['status' => $request->status]);
        }

        return back()->with('success', 'Status updated.');
    }

    public function uploadReport(Request $request, Order $order)
    {
        if ($order->claimed_by !== auth()->id() && auth()->user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'report' => 'required|file|mimes:pdf|max:10240', // 10MB PDF
            'ai_percentage' => 'nullable|numeric|min:0|max:100',
            'plag_percentage' => 'nullable|numeric|min:0|max:100',
        ]);

        $path = $request->file('report')->store('reports/' . $order->id);

        $order->report()->updateOrCreate([], [
            'report_path' => $path
        ]);

        $order->update([
            'ai_percentage' => $request->ai_percentage,
            'plag_percentage' => $request->plag_percentage,
        ]);

        return back()->with('success', 'Report uploaded.');
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
