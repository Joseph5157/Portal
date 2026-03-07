<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientMatrixController extends Controller
{
    public function index()
    {
        $clients = Client::withCount('orders')->get();
        return view('admin.matrix.index', compact('clients'));
    }

    public function update(Request $request, Client $matrix)
    {
        // Parameter is named $matrix based on the resource route convention (admin/matrix/{matrix})
        $request->validate([
            'slots' => 'required|integer|min:0',
            'status' => 'required|in:active,suspended'
        ]);

        $matrix->update([
            'slots' => $request->slots,
            'status' => $request->status,
        ]);

        return back()->with('success', 'Client profile updated successfully.');
    }
    public function refill(Request $request, Client $client)
    {
        $request->validate([
            'additional_slots' => 'required|integer|min:1',
        ]);

        // Update the total slots and set status back to active
        $client->update([
            'slots' => $client->slots + $request->additional_slots,
            'status' => 'active'
        ]);

        return back()->with('success', "Added {$request->additional_slots} slots to {$client->name}. Account is now Active.");
    }
}
