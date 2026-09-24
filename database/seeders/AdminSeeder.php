<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // 1. Pemilik Kos (Owner)
        $ownerExists = DB::table('users')->where('email', 'bagasirbany@gmail.com')->exists();
        if (!$ownerExists) {
            DB::table('users')->insert([
                'name' => 'Bagas Irbany',
                'email' => 'bagasirbany@gmail.com',
                'password' => Hash::make('bagas123'),
                'role' => 'pemilik',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            echo "Pemilik Kos (Bagas) created successfully!\n";
        } else {
            DB::table('users')->where('email', 'bagasirbany@gmail.com')->update([
                'name' => 'Bagas Irbany',
                'password' => Hash::make('bagas123'),
                'role' => 'pemilik',
            ]);
            echo "Pemilik Kos (Bagas) updated successfully!\n";
        }

        // 2. Admin Web (Super Admin / IT)
        $adminExists = DB::table('users')->where('email', 'admin@gmail.com')->exists();
        if (!$adminExists) {
            DB::table('users')->insert([
                'name' => 'Admin Web',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin_web',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            echo "Admin Web (admin@gmail.com) created successfully!\n";
        } else {
            DB::table('users')->where('email', 'admin@gmail.com')->update([
                'name' => 'Admin Web',
                'password' => Hash::make('admin123'),
                'role' => 'admin_web',
            ]);
            echo "Admin Web (admin@gmail.com) updated successfully!\n";
        }
    }
}