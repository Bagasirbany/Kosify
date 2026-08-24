<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WebSetting;
use Illuminate\Support\Facades\Cache;

class WebSettingController extends Controller
{
    public function index()
    {
        $settings = Cache::remember('web_settings_all', 300, function () {
            return WebSetting::pluck('value', 'key')->toArray();
        });
        return view('admin.settings', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'hero_title' => 'required|string|max:255',
            'hero_subtitle' => 'required|string',
            'hero_button_text' => 'nullable|string|max:100',
            'hero_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'owner_name' => 'nullable|string|max:150',
            'owner_phone' => 'nullable|string|max:50',
            'owner_email' => 'nullable|email|max:150',
            'kos_address' => 'nullable|string|max:255',
            'announcement_banner' => 'nullable|string|max:255',
        ]);

        $fields = [
            'hero_title' => $request->hero_title,
            'hero_subtitle' => $request->hero_subtitle,
            'hero_button_text' => $request->hero_button_text ?: 'Cari Kamarmu',
            'owner_name' => $request->owner_name ?: 'Bpk. Kosify Owner',
            'owner_phone' => $request->owner_phone ?: '0812-3456-7890',
            'owner_email' => $request->owner_email ?: 'owner@kosify.com',
            'kos_address' => $request->kos_address ?: 'Jl. Kosify Raya No. 88, Pusat Kota',
            'announcement_banner' => $request->announcement_banner,
            'midtrans_server_key' => $request->midtrans_server_key,
            'midtrans_client_key' => $request->midtrans_client_key,
            'midtrans_is_production' => $request->midtrans_is_production ? '1' : '0',
        ];

        foreach ($fields as $key => $value) {
            WebSetting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        if ($request->hasFile('hero_image')) {
            $imagePath = $request->file('hero_image')->store('settings', 'public');
            WebSetting::updateOrCreate(['key' => 'hero_image'], ['value' => $imagePath]);
        }

        // Clear settings cache immediately
        Cache::forget('web_settings_all');

        return redirect()->back()->with('success', 'Pengaturan Beranda & Informasi Kos berhasil disimpan!');
    }
}
