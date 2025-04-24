<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmployerSeeder extends Seeder
{
    public function run()
    {
        // Use updateOrCreate to prevent duplicates
        DB::table('employers')->updateOrInsert(
            ['matricul_employer' => 'EMP001'],
            [
                'nom' => 'Dupont',
                'prenom' => 'Jean',
                'email' => 'jean.dupont@example.com',
                'telephone' => '0612345678',
                'passwordE' => bcrypt('password123'),
                'role' => 'Manager',
                'date_embauche' => '2020-01-15',
                'post' => 'Chef de Département',
                'apartment' => 'Gestion Urbaine',
                'created_at' => now(),
                'updated_at' => now()
            ]
        );

        DB::table('employers')->updateOrInsert(
            ['matricul_employer' => 'EMP002'],
            [
                'nom' => 'Martin',
                'prenom' => 'Sophie',
                'email' => 'sophie.martin@example.com',
                'telephone' => '0698765432',
                'passwordE' => bcrypt('securepass'),
                'role' => 'Analyste',
                'date_embauche' => '2021-05-20',
                'post' => 'Chargée d\'Études',
                'apartment' => 'Études',
                'created_at' => now(),
                'updated_at' => now()
            ]
        );
    }
}