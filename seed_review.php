<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Review;
use App\Models\Room;
use App\Models\User;

$user = User::first();
$room = Room::first();

if ($user && $room && Review::count() == 0) {
    Review::create([
        'user_id' => $user->id,
        'room_id' => $room->id,
        'rating' => 5,
        'comment' => 'Kamar sangat nyaman, bersih, dan WiFi-nya kencang banget buat nugas malam. Ibu kos dan pengelola sangat ramah dan responsif!',
    ]);
    echo "Seed initial review successful!\n";
} else {
    echo "Reviews already exist or no user/room.\n";
}
