<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Worker;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class AttendanceSeeder extends Seeder
{
    public function run(): void
    {
        $workers = Worker::all();
        $statuses = ['hadir', 'hadir', 'hadir', 'hadir', 'absen', 'sakit', 'izin'];

        foreach ($workers as $worker) {
            for ($i = 0; $i < 7; $i++) {
                Attendance::create([
                    'worker_id' => $worker->id,
                    'afdeling_id' => $worker->afdeling_id,
                    'date' => Carbon::today()->subDays($i),
                    'status' => $statuses[array_rand($statuses)],
                    'notes' => null,
                ]);
            }
        }
    }
}
