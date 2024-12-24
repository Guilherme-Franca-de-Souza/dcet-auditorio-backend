<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Administrador
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'matricula' => 'ADM123456',
            'role' => 'COORDINATOR',
            'cpf' => '11111111111',
            'is_admin' => true,
            'approved' => true,
        ]);

        // Usuários comuns
        User::create([
            'name' => 'Professor One',
            'email' => 'professor@example.com',
            'password' => Hash::make('password'),
            'matricula' => 'PROF123456',
            'role' => 'PROFESSOR',
            'cpf' => '22222222222',
            'is_admin' => false,
            'approved' => true,
        ]);

        User::create([
            'name' => 'Technician One',
            'email' => 'technician@example.com',
            'password' => Hash::make('password'),
            'matricula' => 'TECH123456',
            'role' => 'TECHNICIAN',
            'cpf' => '33333333333',
            'is_admin' => false,
            'approved' => true,
        ]);

        User::create([
            'name' => 'Student One',
            'email' => 'student@example.com',
            'password' => Hash::make('password'),
            'matricula' => 'STUD123456',
            'role' => 'OTHER',
            'cpf' => '44444444444',
            'is_admin' => false,
            'approved' => true,
        ]);
    }
}
