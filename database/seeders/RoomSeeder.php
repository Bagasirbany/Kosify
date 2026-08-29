<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;
use Illuminate\Support\Str;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds with 9 real room profiles and authentic photography.
     */
    public function run(): void
    {
        $roomsData = [
            [
                'room_number' => '101',
                'room_type' => 'Deluxe',
                'price_per_month' => 1500000,
                'status' => 'available',
                'description' => 'Kamar Deluxe Lantai 1 dengan nuansa hangat minimalis, dilengkapi meja kerja luas, pendingin ruangan (AC), kasur queen size empuk, lemari pakaian 2 pintu, dan kamar mandi dalam dengan shower.',
                'photo' => 'images/rooms/room_101.jpg',
            ],
            [
                'room_number' => '102',
                'room_type' => 'Standard',
                'price_per_month' => 1200000,
                'status' => 'available',
                'description' => 'Kamar Standard Lantai 1 yang sangat cocok untuk mahasiswa dan pelajar. Dilengkapi meja belajar, kursi ergonomis, kasur single springbed, ventilasi jendela luas dengan cahaya alami, dan WiFi kencang.',
                'photo' => 'images/rooms/room_102.jpg',
            ],
            [
                'room_number' => '122',
                'room_type' => 'Standard',
                'price_per_month' => 1500000,
                'status' => 'occupied',
                'description' => 'Kamar Standard eksklusif di sudut tenang lantai 1. Dilengkapi kasur single premium, meja kerja, kamar mandi dalam, dan akses cepat ke dapur bersama.',
                'photo' => 'images/rooms/room_122.jpg',
            ],
            [
                'room_number' => '201',
                'room_type' => 'Suite',
                'price_per_month' => 2100000,
                'status' => 'available',
                'description' => 'Kamar Suite Eksekutif Lantai 2 dengan ruangan sangat lapang, interior kayu modern berkelas, smart TV, water heater, AC inverter hemat daya, kulkas mini, dan area santai.',
                'photo' => 'images/rooms/room_201.jpg',
            ],
            [
                'room_number' => '202',
                'room_type' => 'Standard',
                'price_per_month' => 1200000,
                'status' => 'available',
                'description' => 'Kamar Standard Lantai 2 bernuansa aesthetic putih bersih. Dilengkapi tempat tidur single, meja belajar, lemari, rak buku gantung, dan sirkulasi udara segar.',
                'photo' => 'images/rooms/room_202.jpg',
            ],
            [
                'room_number' => '203',
                'room_type' => 'Deluxe',
                'price_per_month' => 1500000,
                'status' => 'available',
                'description' => 'Kamar Deluxe Lantai 2 dengan aksen dinding kayu Scandinavian, kasur queen, AC dingin, meja rias/kerja, dan kamar mandi dalam modern.',
                'photo' => 'images/rooms/room_203.jpg',
            ],
            [
                'room_number' => '301',
                'room_type' => 'Suite',
                'price_per_month' => 2100000,
                'status' => 'available',
                'description' => 'Kamar Suite VIP Lantai 3 dengan pemandangan kota, balkon privat, kasur king size, sofa relaksasi, meja kerja eksekutif, water heater, dan kulkas mini.',
                'photo' => 'images/rooms/room_301.jpg',
            ],
            [
                'room_number' => '302',
                'room_type' => 'Standard',
                'price_per_month' => 1300000,
                'status' => 'available',
                'description' => 'Kamar Standard Lantai 3 yang tenang dan nyaman untuk istirahat maupun belajar. Dilengkapi kasur springbed single, meja belajar, rak penyimpanan, dan WiFi kencang 24 jam.',
                'photo' => 'images/rooms/room_302.jpg',
            ],
            [
                'room_number' => '303',
                'room_type' => 'Deluxe',
                'price_per_month' => 1600000,
                'status' => 'available',
                'description' => 'Kamar Deluxe Lantai 3 berdesain kontemporer layaknya kamar hotel butik. Dilengkapi kasur queen premium, pendingin ruangan (AC), water heater, dan pencahayaan ambient hangat.',
                'photo' => 'images/rooms/room_303.jpg',
            ],
        ];

        foreach ($roomsData as $data) {
            $existing = Room::where('room_number', $data['room_number'])->first();
            if ($existing) {
                $existing->update($data);
            } else {
                $data['id'] = Str::uuid()->toString();
                Room::create($data);
            }
        }
    }
}
