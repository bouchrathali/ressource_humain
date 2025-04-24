<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Manager extends Authenticatable
{
    use HasFactory, Notifiable;

    // Specify the table name (you have already done this correctly)
    protected $table = 'managers';

    // Define the primary key column (since it's not the default 'id')
    protected $primaryKey = 'matricul_manager';

    // Set the primary key type to string since 'matricul_manager' is a string
    protected $keyType = 'string';

    // Disable auto-incrementing since 'matricul_manager' is not auto-incremented
    public $incrementing = false;

    // Define the fillable fields for mass assignment
    protected $fillable = [
        'matricul_manager',
        'nom',
        'prenom',
        'email',
        'telephone',
        'apartment',
        'password',
    ];

    // Hide sensitive data, like password and remember_token
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Define the casting of attributes, especially for email verification
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Optional: Define the guard for this model explicitly (for clarity)
    protected $guard = 'manager'; // This tells the model to use the 'manager' guard

    // Optional: You can add any additional methods for managing Manager-specific functionality.
}
