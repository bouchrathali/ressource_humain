<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Presence extends Model
{
    use HasFactory;

    protected $fillable = [
        'matricule_employer',
        'date',
        'arrive_time',
        'leave_time',
        'status'
    ];

    protected $casts = [
        'date' => 'date',
        'arrive_time' => 'datetime:H:i',
        'leave_time' => 'datetime:H:i'
    ];

    /**
     * Get the employer associated with the presence record
     */
    public function employer(): BelongsTo
    {
        return $this->belongsTo(Employer::class, 'matricule_employer', 'matricul_employer');
    }
}