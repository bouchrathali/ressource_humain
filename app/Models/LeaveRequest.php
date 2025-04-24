<?php

// app/Models/LeaveRequest.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'matricul_employer',
        'matricul_manager',
        'start_date',
        'end_date',
        'type',
        'reason',
        'status',
        'manager_comment',
        'approved_at'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'approved_at' => 'datetime'
    ];

    public function employee()
    {
        return $this->belongsTo(Employer::class, 'matricul_employer', 'matricul_employer');
    }

    public function manager()
    {
        return $this->belongsTo(Manager::class, 'matricul_manager', 'matricul_manager');
    }
}