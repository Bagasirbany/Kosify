<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = App\Models\User::where('email', 'bagasirbany@gmail.com')->first();
if ($user) {
    $user->password = Hash::make('bagasirbany0204');
    $user->save();
    echo "Password updated successfully.\n";
} else {
    echo "User not found.\n";
}
