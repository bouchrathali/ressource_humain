<?php

namespace Database\Seeders;

use App\Models\Manager;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ManagerSeeder extends Seeder
{
    public function run()
    {
        Manager::updateOrCreate(
            ['matricul_manager' => 'MGR001'],
            [
                'nom' => 'Alaoui',
                'prenom' => 'Mohamed',
                'email' => 'm.alaoui@example.com',
                'telephone' => '0611223344',
                'apartment' => 'Gestion Urbaine',
                'password' => Hash::make('SecurePassword123!'),
            ]
        );

        Manager::updateOrCreate(
            ['matricul_manager' => 'MGR002'],
            [
                'nom' => 'Benali',
                'prenom' => 'Fatima',
                'email' => 'f.benali@example.com',
                'telephone' => '0622334455',
                'apartment' => 'Études',
                'password' => Hash::make('StrongPass456@'),
            ]
        );
    }
}