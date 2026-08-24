<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

if (!Schema::hasTable('complaints')) {
    Schema::create('complaints', function (Blueprint $table) {
        $table->uuid('id')->primary();
        $table->string('user_id')->nullable();
        $table->string('room_id')->nullable();
        $table->string('title');
        $table->string('category')->default('Lainnya');
        $table->text('description');
        $table->string('photo')->nullable();
        $table->string('status')->default('pending');
        $table->text('admin_notes')->nullable();
        $table->timestamps();
    });
    echo "Table 'complaints' created successfully!\n";
} else {
    echo "Table 'complaints' already exists!\n";
}

if (!Schema::hasTable('reviews')) {
    Schema::create('reviews', function (Blueprint $table) {
        $table->uuid('id')->primary();
        $table->string('user_id');
        $table->string('room_id');
        $table->string('reservation_id')->nullable();
        $table->integer('rating')->default(5);
        $table->text('comment');
        $table->timestamps();
    });
    echo "Table 'reviews' created successfully!\n";
} else {
    echo "Table 'reviews' already exists!\n";
}
