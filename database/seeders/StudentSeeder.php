<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Aluno Teste',
            'email' => 'student@example.com',
            'password' => Hash::make('password123'),
            'role' => 'student',
        ]);
    }
}
