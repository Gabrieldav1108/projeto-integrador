<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        DB::table('users')->insert([
            'id' => 1, // ID FIXO para admin
            'name' => 'Administrador',
            'email' => 'admin@escola.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Teacher users COM IDs FIXOS
        $teachers = [
            ['id' => 2, 'name' => 'Prof. Carlos Silva', 'email' => 'carlos.silva@escola.com'],
            ['id' => 3, 'name' => 'Prof. Ana Santos', 'email' => 'ana.santos@escola.com'],
            ['id' => 4, 'name' => 'Prof. João Pereira', 'email' => 'joao.pereira@escola.com'],
            ['id' => 5, 'name' => 'Prof. Maria Oliveira', 'email' => 'maria.oliveira@escola.com'],
        ];

        foreach ($teachers as $teacher) {
            DB::table('users')->insert([
                'id' => $teacher['id'],
                'name' => $teacher['name'],
                'email' => $teacher['email'],
                'password' => Hash::make('password123'),
                'role' => 'teacher',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Student users COM IDs FIXOS
        $students = [
            ['id' => 6, 'name' => 'Aluno Pedro Costa', 'email' => 'pedro.costa@escola.com'],
            ['id' => 7, 'name' => 'Aluna Mariana Lima', 'email' => 'mariana.lima@escola.com'],
            ['id' => 8, 'name' => 'Aluno Lucas Almeida', 'email' => 'lucas.almeida@escola.com'],
            ['id' => 9, 'name' => 'Aluna Sofia Rodrigues', 'email' => 'sofia.rodrigues@escola.com'],
            ['id' => 10, 'name' => 'Aluno Bruno Santos', 'email' => 'bruno.santos@escola.com'],
            ['id' => 11, 'name' => 'Aluna Carla Mendes', 'email' => 'carla.mendes@escola.com'],
        ];

        foreach ($students as $student) {
            DB::table('users')->insert([
                'id' => $student['id'],
                'name' => $student['name'],
                'email' => $student['email'],
                'password' => Hash::make('password123'),
                'role' => 'student',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}