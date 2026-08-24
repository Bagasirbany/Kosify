<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$u = \App\Models\User::where('email', 'bagasirbany@gmail.com')->first();
if ($u) {
    $u->password = \Illuminate\Support\Facades\Hash::make('password');
    $u->save();
    echo "Password Reset for bagasirbany@gmail.com!\n";
} else {
    echo "User not found\n";
}
