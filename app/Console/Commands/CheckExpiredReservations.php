<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reservation;
use App\Models\Room;
use Carbon\Carbon;

class CheckExpiredReservations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kos:check-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Periksa dan perbarui reservasi yang telah melewati masa sewa (auto check-out) serta pulihkan status kamar ke tersedia';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Memulai pengecekan masa sewa kamar kos...');

        $today = Carbon::today();
        $activeReservations = Reservation::whereIn('status', ['active', 'confirmed', 'paid'])->get();
        $expiredCount = 0;
        $roomsFreed = 0;

        foreach ($activeReservations as $reservation) {
            $startDate = Carbon::parse($reservation->start_date);
            $duration = (int) ($reservation->duration_months ?: 1);
            $endDate = $startDate->copy()->addMonths($duration);

            if ($endDate->lt($today)) {
                $reservation->status = 'completed';
                $reservation->save();
                $expiredCount++;

                $roomId = $reservation->room_id;
                // Check if any other active reservation exists for this room
                $hasOtherActive = Reservation::where('room_id', $roomId)
                    ->whereIn('status', ['active', 'confirmed', 'paid'])
                    ->where('id', '!=', $reservation->id)
                    ->exists();

                if (!$hasOtherActive) {
                    $room = Room::find($roomId);
                    if ($room && $room->status === 'occupied') {
                        $room->status = 'available';
                        $room->save();
                        $roomsFreed++;
                        $this->line("Kamar {$room->room_number} berhasil dikembalikan ke status TERSEDIA.");
                    }
                }
            }
        }

        $this->info("Pengecekan selesai: {$expiredCount} reservasi kadaluwarsa diselesaikan, {$roomsFreed} kamar berhasil dibebaskan.");

        return Command::SUCCESS;
    }
}
