<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
// database/seeders/DatabaseSeeder.php

public function run()
{
    $this->call([
        EmployerSeeder::class, // Make sure this runs first
        PresenceTableSeeder::class,
        ManagerSeeder::class,
        PresenceManagerSeeder::class,

    ]);
}
}
