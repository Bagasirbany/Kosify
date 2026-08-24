<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('complaints', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id')->nullable();
            $table->uuid('room_id')->nullable();
            $table->string('title');
            $table->string('category')->default('Lainnya'); // Listrik/Lampu, AC/Pendingin, Air/Kamar Mandi, Furnitur, Kebersihan, Lainnya
            $table->text('description');
            $table->string('photo')->nullable();
            $table->string('status')->default('pending'); // pending, in_progress, resolved
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
