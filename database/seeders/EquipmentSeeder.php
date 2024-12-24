<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Equipment;
use Illuminate\Support\Facades\Hash;

class EquipmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Equipment::create([
            'name' => 'Caixa de som',
        ]);

        Equipment::create([
            'name' => 'Microfone',
        ]);

        Equipment::create([
            'name' => 'Projetor',
        ]);
    }
}
