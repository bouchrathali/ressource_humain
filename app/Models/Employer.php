<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Employer extends Authenticatable
{
    protected $guard = 'employer';

    // Your existing fields...
    protected $fillable = [
        'matricul_employer',
        'nom',
        'prenom',
        'email',
        'telephone',
        'passwordE',
        'role',
        'date_embauche',
        'post',
        'apartment'
    ];

    protected $hidden = [
        'passwordE',
    ];

    public function getAuthPassword()
    {
        return $this->passwordE;
    }
}