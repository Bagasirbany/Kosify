<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $exists = DB::table('users')->where('email', 'bagasirbany@gmail.com')->exists();
        if (!$exists) {
            DB::table('users')->insert([
                'name' => 'bagasirbany',
                'email' => 'bagasirbany@gmail.com',
                'password' => Hash::make('bagasirbany0203'),
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            echo "Admin user created successfully!\n";
        } else {
            DB::table('users')->where('email', 'bagasirbany@gmail.com')->update([
                'password' => Hash::make('bagasirbany0203'),
                'role' => 'admin',
            ]);
            echo "Admin user updated successfully!\n";
        }
    }
}