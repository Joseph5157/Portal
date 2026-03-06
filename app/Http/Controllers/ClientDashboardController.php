<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderFile;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ClientDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $client = $user->client ?? \App\Models\Client::first();

        if (!$client) {
            return redirect()->route('dashboard')->with('error', 'No client found in system.');
        }

        $ordersQuery = Order::where('client_id', $client->id)
            ->where('source', 'account');

        if ($user->role === 'client') {
            $ordersQuery->where('created_by_user_id', $user->id);
        }

        $orders = $ordersQuery->with(['report', 'files', 'client'])
            ->latest()
            ->get();

        return view('client.dashboard', compact('client', 'orders'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $client = $user->client ?? \App\Models\Client::first();

        if (!$client) {
            return back()->with('error', 'No client found to associate this order with.');
        }

        $request->validate([
            'files.*' => 'required|file|mimes:pdf,doc,docx,zip|max:102400', // 100MB max
            'files' => 'required|array|min:1'
        ]);

        $tokenView = Str::random(32);

        $order = Order::create([
            'client_id' => $client->id,
            'token_view' => $tokenView,
            'files_count' => count($request->file('files')),
            'status' => 'pending',
            'due_at' => now()->addMinutes(config('services.portal.default_sla_minutes', 20)),
            'source' => 'account',
            'created_by_user_id' => $user->id,
        ]);

        foreach ($request->file('files') as $file) {
            $path = $file->store('orders/' . $order->id);
            OrderFile::create([
                'order_id' => $order->id,
                'file_path' => $path,
            ]);
        }

        return redirect()->route('client.dashboard')->with('success', 'Order created successfully. Tracking ID: ' . $tokenView);
    }
}
