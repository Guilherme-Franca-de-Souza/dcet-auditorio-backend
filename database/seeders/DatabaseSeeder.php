<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // Chamando os seeders individuais
        $this->call([
            UserSeeder::class,
            AuditoriumSeeder::class,
            ReservationSeeder::class,
        ]);
    }
}
