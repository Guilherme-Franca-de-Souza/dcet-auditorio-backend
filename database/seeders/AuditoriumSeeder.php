<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Auditorium;
use App\Models\Equipment;
use App\Models\Penalty;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuditoriumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Auditorium::create([
            'name' => 'Auditorium A',
            'capacity' => 100,
            'location' => 'Building 1, Floor 2',
        ]);

        Auditorium::create([
            'name' => 'Auditorium B',
            'capacity' => 200,
            'location' => 'Building 2, Floor 1',
        ]);
    }
}
