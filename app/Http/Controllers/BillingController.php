<?php

namespace App\Http\Controllers;

use App\Models\DailyLedger;
use App\Models\Order;
use App\Models\Client;
use Illuminate\Http\Request;

class BillingController extends Controller
{
    // Configurable vendor payout rate (per order delivered)
    const VENDOR_PAYOUT_PER_ORDER = 30.00;

    public function index()
    {
        // Today's real-time snapshot
        $today = today();
        $todayOrders = Order::where('status', 'delivered')
            ->whereDate('delivered_at', $today)
            ->with(['client', 'vendor'])
            ->get();

        $todayRevenue = $todayOrders->sum(fn($o) => $o->client?->price_per_file ?? 100);
        $todayPayouts = $todayOrders->count() * self::VENDOR_PAYOUT_PER_ORDER;
        $todayProfit = $todayRevenue - $todayPayouts;

        // Client breakdown for today
        $todayClientBreakdown = $todayOrders->groupBy('client_id')->map(function ($orders) {
            $client = $orders->first()->client;
            return [
                'name' => $client?->name ?? 'Unknown',
                'orders' => $orders->count(),
                'revenue' => $orders->count() * ($client?->price_per_file ?? 100),
            ];
        })->values();

        // Historical ledger entries
        $ledgers = DailyLedger::orderByDesc('date')->paginate(20);

        return view('admin.billing.index', compact(
            'todayRevenue',
            'todayPayouts',
            'todayProfit',
            'todayClientBreakdown',
            'todayOrders',
            'ledgers'
        ));
    }

    public function show(DailyLedger $ledger)
    {
        return view('admin.billing.show', compact('ledger'));
    }
}
