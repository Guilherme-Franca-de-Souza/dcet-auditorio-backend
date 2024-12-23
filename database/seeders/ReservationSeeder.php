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

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Reservation::create([
            'user_id' => 2, // Professor One
            'auditorium_id' => 1, // Auditorium A
            'start_time' => now()->addDays(1)->setTime(10, 0),
            'end_time' => now()->addDays(1)->setTime(12, 0),
            'description' => 'Lecture on AI',
            'participants_count' => 50,
            'approved' => false,
        ]);

        Reservation::create([
            'user_id' => 3, // Technician One
            'auditorium_id' => 2, // Auditorium B
            'start_time' => now()->addDays(2)->setTime(14, 0),
            'end_time' => now()->addDays(2)->setTime(16, 0),
            'description' => 'Technical Workshop',
            'participants_count' => 100,
            'approved' => true,
        ]);
    }
}
