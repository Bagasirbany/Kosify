<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

if (!Schema::hasColumn('rooms', 'photo')) {
    Schema::table('rooms', function (Blueprint $table) {
        $table->string('photo')->nullable()->after('description');
    });
    echo "Column 'photo' added successfully!\n";
} else {
    echo "Column 'photo' already exists!\n";
}
