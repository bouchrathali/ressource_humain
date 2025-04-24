<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PresenceTableSeeder extends Seeder
{
    public function run()
    {
        // Clear the table first
        DB::table('presence')->truncate();

        $employers = DB::table('employers')->pluck('matricul_employer');

        if ($employers->isEmpty()) {
            $this->command->info('No employers found! Please seed employers first.');
            return;
        }

        $presences = [];

        // Create presence records for the last 30 days for each employer
        foreach ($employers as $matricul) {
            for ($i = 0; $i < 30; $i++) {
                $date = Carbon::now()->subDays($i);
                $status = ['present', 'absent', 'late'][rand(0, 2)];
                
                $presence = [
                    'matricul_employer' => $matricul, // Note: Make sure this matches your column name
                    'date_p' => $date->format('Y-m-d'),
                    'status' => $status,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                if ($status === 'present' || $status === 'late') {
                    $presence['heure_arrive'] = Carbon::createFromTime(8, rand(0, 59), 0)->format('H:i:s');
                    $presence['heure_depart'] = Carbon::createFromTime(16, rand(0, 59), 0)->format('H:i:s');
                }

                $presences[] = $presence;
            }
        }

        // Insert in chunks to avoid memory issues
        foreach (array_chunk($presences, 50) as $chunk) {
            DB::table('presence')->insert($chunk);
        }

        $this->command->info('Presence records seeded successfully!');
    }
}