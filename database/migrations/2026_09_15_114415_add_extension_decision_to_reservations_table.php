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
        Schema::table('reservations', function (Blueprint $table) {
            if (!Schema::hasColumn('reservations', 'extension_decision')) {
                $table->string('extension_decision')->nullable()->default(null);
            }
            if (!Schema::hasColumn('reservations', 'extension_notes')) {
                $table->string('extension_notes')->nullable()->default(null);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            if (Schema::hasColumn('reservations', 'extension_decision')) {
                $table->dropColumn('extension_decision');
            }
            if (Schema::hasColumn('reservations', 'extension_notes')) {
                $table->dropColumn('extension_notes');
            }
        });
    }
};
