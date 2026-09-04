<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class RoomController extends Controller
{
    // Public Catalog
    public function catalog(Request $request)
    {
        $rooms = Room::with(['reservations', 'reviews'])->orderBy('room_number', 'asc')->get();
        return view('catalog', compact('rooms'));
    }

    // Public Detail
    public function show(Room $room)
    {
        $room->load(['reservations', 'reviews.user']);
        $averageRating = round($room->reviews()->avg('rating') ?: 5.0, 1);
        $totalReviews = $room->reviews()->count();
        $settings = \App\Models\WebSetting::pluck('value', 'key')->toArray();
        return view('rooms.show', compact('room', 'averageRating', 'totalReviews', 'settings'));
    }

    // User: Submit Review Kamar
    public function storeReview(Request $request, $room)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:3|max:1000',
        ]);

        $roomId = is_object($room) ? $room->id : $room;
        $targetRoom = Room::findOrFail($roomId);

        \App\Models\Review::create([
            'user_id' => auth()->id(),
            'room_id' => $targetRoom->id,
            'rating' => (int) $request->rating,
            'comment' => trim($request->comment),
        ]);

        // Hapus cache agar dashboard langsung membaca rating terbaru
        Cache::forget('admin_dashboard_metrics');

        return back()->with('success', 'Terima kasih! Ulasan dan rating Anda berhasil disimpan ke database.');
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

        Cache::forget('catalog_available_rooms');
        Cache::forget('home_popular_rooms');

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

        Cache::forget('catalog_available_rooms');
        Cache::forget('home_popular_rooms');

        return back()->with('success', 'Data kamar berhasil diupdate.');
    }

    // Admin Destroy
    public function destroy($id)
    {
        $room = Room::findOrFail($id);
        $room->delete();

        Cache::forget('catalog_available_rooms');
        Cache::forget('home_popular_rooms');

        return redirect()->route('rooms.index')->with('success', 'Kamar berhasil dihapus.');
    }
}
