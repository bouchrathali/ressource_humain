<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class TaskSeeder extends Seeder
{
    public function run()
    {
        try {
            // Verify employers exist first
            $employers = DB::table('employers')
                         ->whereIn('matricul_employer', ['EMP001', 'EMP002'])
                         ->pluck('matricul_employer');
            
            if ($employers->isEmpty()) {
                Log::error('No matching employers found for tasks');
                return;
            }

            // Insert tasks - using updateOrInsert to prevent duplicates
            foreach ([
                [
                    'matricul_employer' => 'EMP001',
                    'title' => 'Complete monthly report',
                    'description' => 'Prepare financial documents',
                    'due_date' => Carbon::now()->addDays(5),
                    'status' => 'pending',
                    'priority' => 'high',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'matricul_employer' => 'EMP002',
                    'title' => 'Client meeting prep',
                    'description' => 'Create presentation slides',
                    'due_date' => Carbon::now()->addDays(2),
                    'status' => 'in_progress',
                    'priority' => 'medium',
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ] as $task) {
                DB::table('tasks')->updateOrInsert(
                    [
                        'matricul_employer' => $task['matricul_employer'],
                        'title' => $task['title']
                    ],
                    $task
                );
            }

            Log::info('Successfully seeded tasks table');

        } catch (\Exception $e) {
            Log::error('TaskSeeder failed: ' . $e->getMessage());
        }
    }
}