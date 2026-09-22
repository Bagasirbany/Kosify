<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RestoreSupabaseDataSeeder extends Seeder
{
    public function run(): void
    {
        $jsonPath = 'C:/Users/Asus/.gemini/antigravity/brain/08c433f5-9a6e-4371-bec3-0bcadf77413d/scratch/supabase_data_backup.json';
        if (!file_exists($jsonPath)) {
            $this->command->error("Backup file not found at: {$jsonPath}");
            return;
        }

        $data = json_decode(file_get_contents($jsonPath), true);
        if (!$data) {
            $this->command->error("Failed to parse JSON backup.");
            return;
        }

        // 1. Users
        if (!empty($data['users'])) {
            foreach ($data['users'] as $user) {
                $user['created_at'] = !empty($user['created_at']) ? Carbon::parse($user['created_at'])->toDateTimeString() : null;
                $user['updated_at'] = !empty($user['updated_at']) ? Carbon::parse($user['updated_at'])->toDateTimeString() : null;
                DB::table('users')->updateOrInsert(['id' => $user['id']], $user);
            }
            $this->command->info("Restored users: " . count($data['users']));
        }

        // 2. Rooms
        if (!empty($data['rooms'])) {
            foreach ($data['rooms'] as $room) {
                $room['created_at'] = !empty($room['created_at']) ? Carbon::parse($room['created_at'])->toDateTimeString() : null;
                // gallery_photos is already json string or null
                DB::table('rooms')->updateOrInsert(['id' => $room['id']], $room);
            }
            $this->command->info("Restored rooms: " . count($data['rooms']));
        }

        // 4. Reservations
        if (!empty($data['reservations'])) {
            foreach ($data['reservations'] as $res) {
                $res['created_at'] = !empty($res['created_at']) ? Carbon::parse($res['created_at'])->toDateTimeString() : null;
                DB::table('reservations')->updateOrInsert(['id' => $res['id']], $res);
            }
            $this->command->info("Restored reservations: " . count($data['reservations']));
        }

        // 5. Payments
        if (!empty($data['payments'])) {
            foreach ($data['payments'] as $pay) {
                $pay['created_at'] = !empty($pay['created_at']) ? Carbon::parse($pay['created_at'])->toDateTimeString() : null;
                $pay['verified_at'] = !empty($pay['verified_at']) ? Carbon::parse($pay['verified_at'])->toDateTimeString() : null;
                DB::table('payments')->updateOrInsert(['id' => $pay['id']], $pay);
            }
            $this->command->info("Restored payments: " . count($data['payments']));
        }

        // 6. Expenses
        if (!empty($data['expenses'])) {
            foreach ($data['expenses'] as $exp) {
                $exp['created_at'] = !empty($exp['created_at']) ? Carbon::parse($exp['created_at'])->toDateTimeString() : null;
                $exp['updated_at'] = !empty($exp['updated_at']) ? Carbon::parse($exp['updated_at'])->toDateTimeString() : null;
                DB::table('expenses')->updateOrInsert(['id' => $exp['id']], $exp);
            }
            $this->command->info("Restored expenses: " . count($data['expenses']));
        }

        // 6. Reviews
        if (!empty($data['reviews'])) {
            foreach ($data['reviews'] as $rev) {
                $rev['created_at'] = !empty($rev['created_at']) ? Carbon::parse($rev['created_at'])->toDateTimeString() : null;
                $rev['updated_at'] = !empty($rev['updated_at']) ? Carbon::parse($rev['updated_at'])->toDateTimeString() : null;
                DB::table('reviews')->updateOrInsert(['id' => $rev['id']], $rev);
            }
            $this->command->info("Restored reviews: " . count($data['reviews']));
        }

        // 9. Complaints
        if (!empty($data['complaints'])) {
            foreach ($data['complaints'] as $comp) {
                $comp['created_at'] = !empty($comp['created_at']) ? Carbon::parse($comp['created_at'])->toDateTimeString() : null;
                $comp['updated_at'] = !empty($comp['updated_at']) ? Carbon::parse($comp['updated_at'])->toDateTimeString() : null;
                DB::table('complaints')->updateOrInsert(['id' => $comp['id']], $comp);
            }
            $this->command->info("Restored complaints: " . count($data['complaints']));
        }

        // 10. WebSettings
        if (!empty($data['web_settings'])) {
            foreach ($data['web_settings'] as $ws) {
                $ws['created_at'] = !empty($ws['created_at']) ? Carbon::parse($ws['created_at'])->toDateTimeString() : null;
                $ws['updated_at'] = !empty($ws['updated_at']) ? Carbon::parse($ws['updated_at'])->toDateTimeString() : null;
                DB::table('web_settings')->updateOrInsert(['key' => $ws['key']], $ws);
            }
            $this->command->info("Restored web_settings: " . count($data['web_settings']));
        }
    }
}
