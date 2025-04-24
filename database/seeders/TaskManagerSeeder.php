<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskManagerSeeder extends Seeder
{
    public function run()
    {
        $tasks = [
            [
                'matricul_manager' => 'MGR001',
                'title' => 'Budget Planning',
                'description' => 'Prepare next year budget',
                'due_date' => '2023-12-31',
                'status' => 'pending'
            ],
            [
                'matricul_manager' => 'MGR002',
                'description' => 'Hiring process for new team',
                'title' => 'Recruitment',
                'due_date' => '2024-01-15',
                'status' => 'in_progress'
            ],
            [
                'matricul_manager' => 'MGR001',
                'title' => 'Client Meeting',
                'description' => 'Meet with ABC Corp representatives',
                'due_date' => '2023-12-18',
                'status' => 'pending'
            ]
        ];

        DB::table('task_manager')->insert($tasks);
    }
}