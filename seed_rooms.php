<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Room;
use Illuminate\Support\Str;

Room::truncate();

$rooms = [
    ['room_number' => '101', 'room_type' => 'Deluxe', 'price_per_month' => 1500000, 'status' => 'available', 'description' => 'Kamar mewah dengan AC, view taman dan full furnish. Cocok untuk profesional.'],
    ['room_number' => '102', 'room_type' => 'Standard', 'price_per_month' => 1200000, 'status' => 'available', 'description' => 'Kamar standar yang nyaman dengan jendela luas dan ventilasi bagus.'],
    ['room_number' => '201', 'room_type' => 'Suite', 'price_per_month' => 2100000, 'status' => 'maintenance', 'description' => 'Suite luas dengan kamar mandi dalam, bathup, dan ruang tamu mini.'],
    ['room_number' => '202', 'room_type' => 'Standard', 'price_per_month' => 1200000, 'status' => 'occupied', 'description' => 'Kamar standar di lantai 2 dekat tangga akses utama.'],
    ['room_number' => '203', 'room_type' => 'Deluxe', 'price_per_month' => 1500000, 'status' => 'available', 'description' => 'Deluxe dengan view perkotaan dari lantai dua. Fasilitas AC dan kulkas.'],
    ['room_number' => '301', 'room_type' => 'Suite', 'price_per_month' => 2100000, 'status' => 'occupied', 'description' => 'Suite premium di lantai teratas dengan pemandangan 180 derajat.'],
    ['room_number' => '302', 'room_type' => 'Standard', 'price_per_month' => 1300000, 'status' => 'available', 'description' => 'Kamar standar dengan fasilitas balkon pribadi.'],
    ['room_number' => '303', 'room_type' => 'Deluxe', 'price_per_month' => 1600000, 'status' => 'available', 'description' => 'Deluxe lantai atas yang tenang dan nyaman untuk work from home.']
];

foreach ($rooms as $r) {
    $r['id'] = Str::uuid()->toString();
    Room::create($r);
}
echo "Seeded rooms!\n";
