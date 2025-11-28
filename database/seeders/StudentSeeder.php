<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Student;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $students = [
            [
                'name' => 'Aluno Pedro Costa',
                'email' => 'pedro.costa@escola.com',
                'age' => 12,
                'birth_date' => Carbon::now()->subYears(12)->subMonths(3)->format('Y-m-d'),
                'password' => Hash::make('password123'),
                'class_id' => 1,
            ],
            [
                'name' => 'Aluna Mariana Lima',
                'email' => 'mariana.lima@escola.com',
                'age' => 13,
                'birth_date' => Carbon::now()->subYears(13)->subMonths(7)->format('Y-m-d'),
                'password' => Hash::make('password123'),
                'class_id' => 1,
            ],
            // ... outros estudantes
        ];

        foreach ($students as $studentData) {
            // Cria apenas o registro na tabela 'student' (sem duplicar usuários)
            Student::create([
                'name' => $studentData['name'],
                'email' => $studentData['email'],
                'age' => $studentData['age'],
                'birth_date' => $studentData['birth_date'],
                'password' => $studentData['password'],
                'class_id' => $studentData['class_id'],
            ]);
        }
    }
}