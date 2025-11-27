<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $students = [
            [
                'name' => 'Aluno Pedro Costa',
                'email' => 'pedro.costa@escola.com',
                'age' => 12,
                'password' => Hash::make('password123'),
                'class_id' => 1, // 6º Ano A
            ],
            [
                'name' => 'Aluna Mariana Lima',
                'email' => 'mariana.lima@escola.com',
                'age' => 13,
                'password' => Hash::make('password123'),
                'class_id' => 1, // 6º Ano A
            ],
            [
                'name' => 'Aluno Lucas Almeida',
                'email' => 'lucas.almeida@escola.com',
                'age' => 14,
                'password' => Hash::make('password123'),
                'class_id' => 3, // 7º Ano A
            ],
            [
                'name' => 'Aluna Sofia Rodrigues',
                'email' => 'sofia.rodrigues@escola.com',
                'age' => 13,
                'password' => Hash::make('password123'),
                'class_id' => 3, // 7º Ano A
            ],
            [
                'name' => 'Aluno Bruno Santos',
                'email' => 'bruno.santos@escola.com',
                'age' => 15,
                'password' => Hash::make('password123'),
                'class_id' => 5, // 8º Ano A
            ],
            [
                'name' => 'Aluna Carla Mendes',
                'email' => 'carla.mendes@escola.com',
                'age' => 14,
                'password' => Hash::make('password123'),
                'class_id' => 5, // 8º Ano A
            ],
        ];

        foreach ($students as $student) {
            DB::table('student')->insert(array_merge($student, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}