<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class RoomController extends Controller
{
    // Public Catalog
    public function catalog(Request $request)
    {
        $rooms = Cache::remember('catalog_all_rooms', 120, function () {
            return Room::with(['reservations', 'reviews'])->orderBy('room_number', 'asc')->get();
        });
        $ownerName = Cache::remember('owner_name_cache', 300, function () {
            return \App\Models\WebSetting::where('key', 'owner_name')->value('value') ?: 'Bagas Irbany';
        });
        return view('catalog', compact('rooms', 'ownerName'));
    }

    // Public Detail
    public function show(Room $room)
    {
        $room->load([
            'reservations',
            'reviews' => function ($query) {
                $query->with('user')->orderBy('created_at', 'desc');
            }
        ]);
        $totalReviews = $room->reviews->count();
        $averageRating = $totalReviews > 0 ? round($room->reviews->avg('rating'), 1) : null;
        $settings = Cache::remember('web_settings_all', 300, function () {
            return \App\Models\WebSetting::pluck('value', 'key')->toArray();
        });

        // Proteksi ketat:
        // 1. Admin TIDAK BISA membuat ulasan (murni hanya bisa memantau/melihat)
        // 2. Penyewa HANYA bisa mereview jika pernah memesan/menempati kamar ini dan belum pernah mengulas
        $canReview = false;
        $hasReviewed = false;

        if (auth()->check()) {
            if (auth()->user()->role !== 'admin') {
                $hasBooked = \App\Models\Reservation::where('user_id', auth()->id())
                    ->where('room_id', $room->id)
                    ->whereIn('status', ['confirmed', 'active', 'completed', 'paid', 'success'])
                    ->exists();

                $hasReviewed = \App\Models\Review::where('user_id', auth()->id())
                    ->where('room_id', $room->id)
                    ->exists();

                $canReview = $hasBooked && !$hasReviewed;
            }
        }

        return view('rooms.show', compact('room', 'averageRating', 'totalReviews', 'settings', 'canReview', 'hasReviewed'));
    }

    // User: Submit Review Kamar (Hanya penyewa yang pernah memesan/menggunakan kamar)
    public function storeReview(Request $request, $room)
    {
        // Admin tidak dapat memposting ulasan kamar
        if (auth()->user()->role === 'admin') {
            return back()->withErrors(['review' => 'Administrator tidak diizinkan membuat ulasan kamar. Hak ulasan khusus untuk penyewa.']);
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:3|max:1000',
        ]);

        $roomId = is_object($room) ? $room->id : $room;
        $targetRoom = Room::findOrFail($roomId);

        // Validasi ketat: User harus terverifikasi pernah memesan kamar ini
        $hasBooked = \App\Models\Reservation::where('user_id', auth()->id())
            ->where('room_id', $targetRoom->id)
            ->whereIn('status', ['confirmed', 'active', 'completed', 'paid', 'success'])
            ->exists();

        if (!$hasBooked) {
            return back()->withErrors(['review' => 'Anda belum dapat memberikan ulasan. Ulasan hanya dapat diberikan oleh penyewa yang telah memesan atau menempati kamar ini.']);
        }

        // Cegah spam ulasan berulang kali
        $alreadyReviewed = Review::where('user_id', auth()->id())
            ->where('room_id', $targetRoom->id)
            ->exists();

        if ($alreadyReviewed) {
            return back()->withErrors(['review' => 'Anda sudah pernah memberikan ulasan untuk kamar ini.']);
        }

        Review::create([
            'user_id' => auth()->id(),
            'room_id' => $targetRoom->id,
            'rating' => (int) $request->rating,
            'comment' => trim($request->comment),
        ]);

        // Hapus cache agar katalog & dashboard langsung membaca rating terbaru
        Cache::forget('catalog_all_rooms');
        Cache::forget('admin_dashboard_metrics');
        Cache::forget('admin_dashboard_full_bundle');

        return back()->with('success', 'Terima kasih! Ulasan dan rating Anda berhasil disimpan.');
    }

    // User: Hapus Ulasan Milik Sendiri (Admin tidak bisa menghapus/mengotak-atik ulasan penyewa)
    public function destroyReview(Review $review)
    {
        if (auth()->id() !== $review->user_id) {
            abort(403, 'Ulasan bersifat independen dan hanya dapat dihapus oleh penyewa pembuat ulasan itu sendiri.');
        }

        $review->delete();
        Cache::forget('catalog_all_rooms');
        Cache::forget('admin_dashboard_metrics');
        Cache::forget('admin_dashboard_full_bundle');

        return back()->with('success', 'Ulasan Anda berhasil dihapus.');
    }

    // Admin Index
    public function adminIndex()
    {
        $rooms = Room::with('reservations')->orderBy('created_at', 'desc')->get();
        return view('kamar', compact('rooms'));
    }

    // Admin Create
    public function create()
    {
        return view('kamar-create');
    }

    // Admin Edit
    public function edit($id)
    {
        $room = Room::findOrFail($id);
        return view('kamar-edit', compact('room'));
    }

    // Admin Store
    public function store(Request $request)
    {
        $request->validate([
            'room_number' => 'required|string|max:10|unique:rooms',
            'room_type' => 'required|string|max:50',
            'price_per_month' => 'required|numeric|min:0',
            'status' => 'required|string',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('room_photos', 'public');
            $data['photo'] = $path;
        }

        $room = new Room($data);
        $room->id = Str::uuid()->toString();
        $room->save();

        Cache::forget('catalog_all_rooms');
        Cache::forget('catalog_available_rooms');
        Cache::forget('home_popular_rooms');
        Cache::forget('admin_dashboard_full_bundle');

        return redirect()->route('rooms.index')->with('success', 'Kamar berhasil ditambahkan.');
    }

    // Admin Edit
    public function adminShow($id)
    {
        $room = Room::findOrFail($id);
        return view('kamar-detail', compact('room'));
    }

    // Admin Update
    public function update(Request $request, $id)
    {
        $room = Room::findOrFail($id);
        
        $request->validate([
            'room_number' => 'required|string|max:10|unique:rooms,room_number,'.$room->id,
            'room_type' => 'required|string|max:50',
            'price_per_month' => 'required|numeric|min:0',
            'status' => 'required|string',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('room_photos', 'public');
            $data['photo'] = $path;
        }

        $room->update($data);

        Cache::forget('catalog_all_rooms');
        Cache::forget('catalog_available_rooms');
        Cache::forget('home_popular_rooms');
        Cache::forget('admin_dashboard_full_bundle');

        return back()->with('success', 'Data kamar berhasil diupdate.');
    }

    // Admin Destroy
    public function destroy($id)
    {
        $room = Room::findOrFail($id);
        $room->delete();

        Cache::forget('catalog_all_rooms');
        Cache::forget('catalog_available_rooms');
        Cache::forget('home_popular_rooms');
        Cache::forget('admin_dashboard_full_bundle');

        return redirect()->route('rooms.index')->with('success', 'Kamar berhasil dihapus.');
    }
}
