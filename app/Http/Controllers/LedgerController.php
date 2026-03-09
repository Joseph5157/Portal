<?php

namespace App\Http\Controllers;

use App\Models\DailyLedger;
use App\Models\Order;

class LedgerController extends Controller
{
    const VENDOR_PAYOUT_PER_ORDER = 30.00;

    public function index()
    {
        $today = today();

        $todayOrders = Order::where('status', 'delivered')
            ->whereDate('delivered_at', $today)
            ->with('client')
            ->get();

        $todayRevenue = $todayOrders->sum(fn($o) => $o->client?->price_per_file ?? 100);
        $todayPayouts = $todayOrders->count() * self::VENDOR_PAYOUT_PER_ORDER;
        $todayProfit = $todayRevenue - $todayPayouts;

        $ledgers = DailyLedger::orderByDesc('date')->paginate(30);

        return view('admin.finance.ledger', compact(
            'todayRevenue',
            'todayPayouts',
            'todayProfit',
            'todayOrders',
            'ledgers'
        ));
    }
}
