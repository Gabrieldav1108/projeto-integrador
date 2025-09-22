<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TeacherSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Professor Teste',
            'email' => 'teacher@example.com',
            'password' => Hash::make('password123'),
            'role' => 'teacher',
        ]);
    }
}
