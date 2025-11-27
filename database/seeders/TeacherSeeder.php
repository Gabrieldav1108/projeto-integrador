<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class TeacherSeeder extends Seeder
{
    public function run(): void
    {
        $teachers = [
            [
                'name' => 'Prof. Carlos Silva',
                'email' => 'carlos.silva@escola.com',
                'password' => Hash::make('password123'),
                'phone' => '(11) 99999-1111',
                'hire_date' => Carbon::create(2020, 1, 15), // Usando Carbon
                'is_active' => 1,
                'user_id' => 2,
                'subject_id' => 1,
            ],
            [
                'name' => 'Prof. Ana Santos',
                'email' => 'ana.santos@escola.com',
                'password' => Hash::make('password123'),
                'phone' => '(11) 99999-2222',
                'hire_date' => Carbon::create(2019, 3, 20),
                'is_active' => 1,
                'user_id' => 3,
                'subject_id' => 2,
            ],
            [
                'name' => 'Prof. João Pereira',
                'email' => 'joao.pereira@escola.com',
                'password' => Hash::make('password123'),
                'phone' => '(11) 99999-3333',
                'hire_date' => Carbon::create(2021, 8, 10),
                'is_active' => 1,
                'user_id' => 4,
                'subject_id' => 3,
            ],
            [
                'name' => 'Prof. Maria Oliveira',
                'email' => 'maria.oliveira@escola.com',
                'password' => Hash::make('password123'),
                'phone' => '(11) 99999-4444',
                'hire_date' => Carbon::create(2018, 2, 5),
                'is_active' => 1,
                'user_id' => 5,
                'subject_id' => 5,
            ],
        ];

        foreach ($teachers as $teacher) {
            DB::table('teachers')->insert(array_merge($teacher, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}    