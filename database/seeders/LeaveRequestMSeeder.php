<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LeaveRequestMSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        LeaveRequest::create([
            'employee_id' => 1,
            'type' => 'annual',
            'start_date' => now()->addDays(5),
            'end_date' => now()->addDays(9),
            'duration' => 5,
            'reason' => 'Family vacation',
            'status' => 'pending'
        ]);
    
        LeaveRequest::create([
            'employee_id' => 2,
            'type' => 'sick',
            'start_date' => now()->addDays(2),
            'end_date' => now()->addDays(4),
            'duration' => 3,
            'reason' => 'Medical procedure',
            'status' => 'pending'
        ]);
    
        LeaveRequest::create([
            'employee_id' => 3,
            'type' => 'unpaid',
            'start_date' => now()->addDays(10),
            'end_date' => now()->addDays(12),
            'duration' => 3,
            'reason' => 'Personal matters',
            'status' => 'approved',
            'approved_by' => 1,
            'approved_at' => now()
        ]);
    }
}
