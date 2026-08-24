<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

// Disable prepared statements on connection for Supabase transaction pooler
DB::connection()->getPdo()->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);

$rooms = DB::select("SELECT id, room_number, photo FROM rooms ORDER BY room_number ASC");

$images = [
    'images/room_1.jpg',
    'images/room_2.jpg',
    'images/room_3.jpg',
    'images/room_4.jpg',
];

echo "Found " . count($rooms) . " rooms in database.\n";

foreach ($rooms as $index => $room) {
    $assignedImage = $images[$index % count($images)];
    DB::update("UPDATE rooms SET photo = ? WHERE id = ?", [$assignedImage, $room->id]);
    echo "Updated Room " . $room->room_number . " with photo: " . $assignedImage . "\n";
}

Cache::forget('home_popular_rooms');
Cache::forget('catalog_available_rooms');

echo "All rooms updated and caches cleared successfully!\n";
