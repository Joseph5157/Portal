<?php

namespace App\Console\Commands;

use App\Models\DailyLedger;
use App\Models\Order;
use Illuminate\Console\Command;

class CloseDayCommand extends Command
{
    protected $signature = 'app:close-day {--date= : Date to close (Y-m-d). Defaults to today.}';
    protected $description = 'Aggregate delivered orders into a daily ledger snapshot.';

    // Per-order vendor payout rate
    const VENDOR_PAYOUT_PER_ORDER = 30.00;

    public function handle(): int
    {
        $date = $this->option('date')
            ? \Carbon\Carbon::parse($this->option('date'))->toDateString()
            : today()->toDateString();

        $this->info("Closing day: {$date}");

        $orders = Order::where('status', 'delivered')
            ->whereDate('delivered_at', $date)
            ->with(['client', 'vendor'])
            ->get();

        if ($orders->isEmpty()) {
            $this->warn("No delivered orders found for {$date}.");
        }

        // Revenue: sum each client's price_per_file
        $totalRevenue = $orders->sum(fn($o) => $o->client?->price_per_file ?? 100);
        $vendorPayouts = $orders->count() * self::VENDOR_PAYOUT_PER_ORDER;
        $operationalCosts = 0; // placeholder for future overhead costs
        $netProfit = $totalRevenue - $vendorPayouts - $operationalCosts;

        // Client breakdown
        $clientBreakdown = $orders->groupBy('client_id')->map(function ($clientOrders) {
            $client = $clientOrders->first()->client;
            $pricePerFile = $client?->price_per_file ?? 100;
            return [
                'id' => $client?->id,
                'name' => $client?->name ?? 'Unknown',
                'orders' => $clientOrders->count(),
                'price_per_file' => $pricePerFile,
                'revenue' => $clientOrders->count() * $pricePerFile,
            ];
        })->values()->toArray();

        // Vendor breakdown
        $vendorBreakdown = $orders->whereNotNull('claimed_by')->groupBy('claimed_by')->map(function ($vendorOrders) {
            $vendor = $vendorOrders->first()->vendor;
            return [
                'id' => $vendor?->id,
                'name' => $vendor?->name ?? 'Unknown',
                'orders' => $vendorOrders->count(),
                'payout' => $vendorOrders->count() * self::VENDOR_PAYOUT_PER_ORDER,
            ];
        })->values()->toArray();

        DailyLedger::updateOrCreate(
            ['date' => $date],
            [
                'total_revenue' => $totalRevenue,
                'vendor_payouts' => $vendorPayouts,
                'operational_costs' => $operationalCosts,
                'net_profit' => $netProfit,
                'client_breakdown' => $clientBreakdown,
                'vendor_breakdown' => $vendorBreakdown,
                'total_orders' => $orders->count(),
            ]
        );

        $this->table(
            ['Date', 'Orders', 'Revenue', 'Payouts', 'Net Profit'],
            [[$date, $orders->count(), '₹' . $totalRevenue, '₹' . $vendorPayouts, '₹' . $netProfit]]
        );

        $this->info('Day closed successfully.');
        return Command::SUCCESS;
    }
}
