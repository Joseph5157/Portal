<?php

namespace App\Http\Controllers;

use App\Models\ClientLink;
use App\Models\Order;
use App\Models\OrderFile;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    public function showUpload($token)
    {
        $link = ClientLink::where('token', $token)->where('is_active', true)->with('client')->firstOrFail();
        $client = $link->client;
        $orders = Order::where('client_id', $client->id)->with('report')->latest()->get();
        return view('client.upload', compact('link', 'client', 'orders'));
    }

    public function store(Request $request, $token)
    {
        $link = ClientLink::where('token', $token)->where('is_active', true)->with('client')->firstOrFail();
        $client = $link->client;

        $request->validate([
            'files.*' => 'required|file|mimes:pdf,doc,docx,zip|max:51200', // 50MB max
            'files' => 'required|array|min:1'
        ]);

        $tokenView = Str::random(32);

        $order = Order::create([
            'client_id' => $client->id,
            'token_view' => $tokenView,
            'files_count' => count($request->file('files')),
            'status' => 'pending',
            'due_at' => now()->addMinutes(20),
        ]);

        foreach ($request->file('files') as $file) {
            $path = $file->store('orders/' . $order->id);
            OrderFile::create([
                'order_id' => $order->id,
                'file_path' => $path,
            ]);
        }

        return redirect()->route('client.track', $tokenView);
    }

    public function track($token_view)
    {
        $order = Order::where('token_view', $token_view)->with(['report', 'client'])->firstOrFail();
        return view('client.track', compact('order'));
    }

    public function download($token_view)
    {
        $order = Order::where('token_view', $token_view)->with('report')->firstOrFail();

        if ($order->status !== 'delivered' || !$order->report) {
            abort(404);
        }

        if ($order->is_downloaded) {
            return back()->with('error', 'Report has already been downloaded once.');
        }

        $order->update(['is_downloaded' => true]);

        return Storage::download($order->report->report_path, 'report-' . $order->id . '.pdf');
    }
}
