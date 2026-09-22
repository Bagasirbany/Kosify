<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of all users (Admin Web only).
     */
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        $roleCounts = [
            'all' => User::count(),
            'admin_web' => User::where('role', 'admin_web')->count(),
            'pemilik' => User::whereIn('role', ['pemilik', 'admin'])->count(),
            'penyewa' => User::where('role', 'penyewa')->orWhereNull('role')->count(),
        ];

        return view('admin.users', compact('users', 'roleCounts'));
    }

    /**
     * Update user role.
     */
    public function updateRole(Request $request, User $user)
    {
        $validated = $request->validate([
            'role' => 'required|in:admin_web,pemilik,penyewa',
        ]);

        // Prevent admin from demoting themselves
        if (auth()->id() === $user->id && $validated['role'] !== 'admin_web') {
            return back()->with('error', 'Anda tidak dapat mengubah peran akun Anda sendiri.');
        }

        $user->role = $validated['role'];
        $user->save();

        return back()->with('success', "Peran akun {$user->name} ({$user->email}) berhasil diubah menjadi " . strtoupper(str_replace('_', ' ', $validated['role'])) . ".");
    }

    /**
     * Reset password for a user.
     */
    public function resetPassword(Request $request, User $user)
    {
        $validated = $request->validate([
            'new_password' => 'nullable|string|min:6',
        ]);

        $newPassword = $validated['new_password'] ?: 'kosify123';
        $user->password = Hash::make($newPassword);
        $user->save();

        return back()->with('success', "Kata sandi akun {$user->name} berhasil direset menjadi: {$newPassword}");
    }
}
