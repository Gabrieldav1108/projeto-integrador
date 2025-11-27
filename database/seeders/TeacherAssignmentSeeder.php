<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeacherAssignmentSeeder extends Seeder
{
    public function run(): void
    {
        // Primeiro, vamos atribuir matérias específicas para cada professor
        $teacherSubjects = [
            // Prof. Carlos Silva (ID: 2) - Matemática
            2 => [1], // Matemática
            // Prof. Ana Santos (ID: 3) - Português e Inglês
            3 => [2, 6], // Português e Inglês
            // Prof. João Pereira (ID: 4) - História e Geografia
            4 => [3, 4], // História e Geografia
            // Prof. Maria Oliveira (ID: 5) - Ciências e Educação Física
            5 => [5, 7], // Ciências e Educação Física
        ];

        // Atribuir turmas para cada professor
        $teacherClasses = [
            // Prof. Carlos Silva - Turmas do 6º e 7º Ano
            2 => [1, 2, 3, 4], // 6ºA, 6ºB, 7ºA, 7ºB
            // Prof. Ana Santos - Todas as turmas
            3 => [1, 2, 3, 4, 5, 6, 7, 8],
            // Prof. João Pereira - Turmas do 8º e 9º Ano
            4 => [5, 6, 7, 8], // 8ºA, 8ºB, 9ºA, 9ºB
            // Prof. Maria Oliveira - Turmas do 6º e 9º Ano
            5 => [1, 2, 7, 8], // 6ºA, 6ºB, 9ºA, 9ºB
        ];

        // Relacionar professores com turmas (tabela class_user)
        foreach ($teacherClasses as $teacherId => $classIds) {
            foreach ($classIds as $classId) {
                DB::table('class_user')->insert([
                    'class_id' => $classId,
                    'user_id' => $teacherId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // Relacionar matérias com turmas (tabela class_subject)
        $classSubjects = [
            // 6º Ano A e B
            1 => [1, 2, 3, 4, 5, 6, 7, 8], // Todas as matérias
            2 => [1, 2, 3, 4, 5, 6, 7, 8],
            // 7º Ano A e B
            3 => [1, 2, 3, 4, 5, 6, 7, 8],
            4 => [1, 2, 3, 4, 5, 6, 7, 8],
            // 8º Ano A e B
            5 => [1, 2, 3, 4, 5, 6, 7],
            6 => [1, 2, 3, 4, 5, 6, 7],
            // 9º Ano A e B
            7 => [1, 2, 3, 4, 5, 6, 7],
            8 => [1, 2, 3, 4, 5, 6, 7],
        ];

        foreach ($classSubjects as $classId => $subjectIds) {
            foreach ($subjectIds as $subjectId) {
                DB::table('class_subject')->insert([
                    'class_id' => $classId,
                    'subject_id' => $subjectId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // Você pode adicionar aqui uma tabela teacher_subject se precisar
        // de um relacionamento direto entre professores e matérias
    }
}