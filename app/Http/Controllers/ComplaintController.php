<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\Room;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComplaintController extends Controller
{
    // Tenant: Halaman Lapor Kendala & Daftar Tiket
    public function index()
    {
        $user = Auth::user();
        $complaints = Complaint::with('room')->where('user_id', $user->id)->latest()->get();

        // Cari kamar aktif yang sedang disewa penyewa
        $activeReservation = Reservation::with('room')
            ->where('user_id', $user->id)
            ->whereIn('status', ['active', 'confirmed', 'paid', 'success'])
            ->latest()
            ->first();

        return view('complaints.index', compact('complaints', 'activeReservation'));
    }

    // Tenant: Kirim Laporan Kendala Baru
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:150',
            'category' => 'required|string|max:50',
            'description' => 'required|string|min:10',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'room_id' => 'nullable|string',
        ]);

        $data = [
            'user_id' => Auth::id(),
            'room_id' => $request->room_id,
            'title' => $request->title,
            'category' => $request->category,
            'description' => $request->description,
            'status' => 'pending',
        ];

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('complaint_photos', 'public');
            $data['photo'] = $path;
        }

        Complaint::create($data);

        return redirect()->route('complaints.index')->with('success', 'Laporan kendala berhasil dikirim! Tim pengelola akan segera menindaklanjuti.');
    }

    // Admin: Kelola Seluruh Tiket Komplain
    public function adminIndex(Request $request)
    {
        $query = Complaint::with(['user', 'room'])->latest();

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        $complaints = $query->get();
        $pendingCount = Complaint::where('status', 'pending')->count();
        $inProgressCount = Complaint::where('status', 'in_progress')->count();
        $resolvedCount = Complaint::where('status', 'resolved')->count();

        return view('admin.complaints', compact('complaints', 'pendingCount', 'inProgressCount', 'resolvedCount'));
    }

    // Admin: Update Status & Catatan Pengerjaan
    public function adminUpdateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,resolved',
            'admin_notes' => 'nullable|string',
        ]);

        $complaint = Complaint::findOrFail($id);
        $complaint->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
        ]);

        return back()->with('success', 'Status tiket kendala berhasil diperbarui.');
    }
}
