<?php

use App\Models\WebSetting;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$settings = [
    ['key' => 'hero_title', 'value' => 'KOSIFY'],
    ['key' => 'hero_subtitle', 'value' => 'Temukan kos impianmu dengan fasilitas lengkap, desain estetis, dan proses booking yang bebas ribet dalam satu platform.'],
    ['key' => 'hero_image', 'value' => ''],
];

foreach ($settings as $setting) {
    WebSetting::firstOrCreate(['key' => $setting['key']], ['value' => $setting['value']]);
}

echo "Settings seeded successfully.\n";
