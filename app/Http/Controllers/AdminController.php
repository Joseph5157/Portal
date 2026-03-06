<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function storeAccount(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required', 'in:vendor,client,admin'],
        ]);

        // Create the standard user account
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        // If the role is 'client', automatically provision their Client profile
        if ($request->role === 'client') {
            Client::create([
                // Adjust these fields based on your actual Client migration
                'name' => $request->name . ' Account',
                'user_id' => $user->id,
                'slots' => 50, // Default usage credits
            ]);
        }

        return back()->with('success', ucfirst($request->role) . ' account created successfully!');
    }
}