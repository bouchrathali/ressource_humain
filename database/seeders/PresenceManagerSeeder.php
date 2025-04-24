<?php

namespace Database\Seeders;

use App\Models\Manager;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PresenceManagerSeeder extends Seeder
{
    public function run()
    {
        // Clear the table first
        DB::table('presence_manager')->truncate();

        // Get all managers
        $managers = Manager::all();

        if ($managers->isEmpty()) {
            $this->command->info('No managers found! Please seed managers first.');
            return;
        }

        $presences = [];

        foreach ($managers as $manager) {
            // Create records for the last 30 days
            for ($i = 0; $i < 30; $i++) {
                $date = Carbon::now()->subDays($i);
                $isWeekend = $date->isWeekend();
                $status = $isWeekend ? 'absent' : ['present', 'present', 'present', 'late'][rand(0, 3)];
                
                $presence = [
                    'matricul_manager' => $manager->matricul_manager,
                    'date' => $date->format('Y-m-d'),
                    'status' => $status,
                    'check_in' => !$isWeekend && in_array($status, ['present', 'late']) 
                        ? ($status === 'present' 
                            ? Carbon::createFromTime(8, rand(0, 30))->format('H:i:s')
                            : Carbon::createFromTime(9, rand(0, 45))->format('H:i:s'))
                        : null,
                    'check_out' => !$isWeekend && in_array($status, ['present', 'late'])
                        ? Carbon::createFromTime(16, rand(0, 45))->format('H:i:s')
                        : null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                $presences[] = $presence;
            }
        }

        // Insert in chunks
        foreach (array_chunk($presences, 50) as $chunk) {
            DB::table('presence_manager')->insert($chunk);
        }

        $this->command->info('Successfully seeded '.count($presences).' manager presence records!');
    }
}