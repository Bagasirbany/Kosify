<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class TenantController extends Controller
{
    public function index()
    {
        // Get all users who are not admins (tenants)
        $tenants = User::where(function($q) {
            $q->where('role', '!=', 'admin')->orWhereNull('role');
        })->orderBy('created_at', 'desc')->get();

        return view('penyewa', compact('tenants'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => \Illuminate\Support\Facades\Hash::make($validated['password']),
            'role' => 'user', // default role for tenants
        ]);

        return redirect()->route('tenants.index')->with('success', 'Penyewa berhasil ditambahkan!');
    }
}
