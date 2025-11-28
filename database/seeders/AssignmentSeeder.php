<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssignmentSeeder extends Seeder
{
    public function run(): void
    {
        $assignments = [
            [
                'class_id' => 1,
                'subject_id' => 1,
                'teacher_id' => 1,
                'title' => 'Exercícios de Álgebra',
                'description' => 'Resolver problemas do capítulo 3',
                'due_date' => now()->addDays(7)->toDateString(),
                'due_time' => '23:59:00',
                'max_points' => 10,
                'is_active' => 1,
            ],
            [
                'class_id' => 3,
                'subject_id' => 2,
                'teacher_id' => 2,
                'title' => 'Redação sobre preservação',
                'description' => 'Escrever uma redação de 500 palavras',
                'due_date' => now()->addDays(10)->toDateString(),
                'due_time' => '17:00:00',
                'max_points' => 10,
                'is_active' => 1,
            ],
        ];

        foreach ($assignments as $assignment) {
            DB::table('assignments')->insert(array_merge($assignment, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        // Inserir submissões de exemplo (assignment_submissions)
        $submission = [
            'assignment_id' => 1,
            'student_id' => 6, // usuário Pedro
            'file_path' => null,
            'comments' => 'Entrega inicial',
            'points' => null,
            'feedback' => null,
            'submitted_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ];

        DB::table('assignment_submissions')->insert($submission);
    }
}
