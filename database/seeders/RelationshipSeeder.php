<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RelationshipSeeder extends Seeder
{
    public function run(): void
    {
        // class_user - relaciona professores com turmas
        $classTeachers = [
            ['class_id' => 1, 'user_id' => 2], // Carlos - 6ºA
            ['class_id' => 2, 'user_id' => 2], // Carlos - 6ºB
            ['class_id' => 3, 'user_id' => 3], // Ana - 7ºA
            ['class_id' => 4, 'user_id' => 3], // Ana - 7ºB
            ['class_id' => 5, 'user_id' => 4], // João - 8ºA
            ['class_id' => 6, 'user_id' => 4], // João - 8ºB
            ['class_id' => 7, 'user_id' => 5], // Maria - 9ºA
            ['class_id' => 8, 'user_id' => 5], // Maria - 9ºB
        ];

        foreach ($classTeachers as $relation) {
            DB::table('class_user')->insert(array_merge($relation, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        // class_user - relaciona ALUNOS (users) com turmas
        $classStudents = [
            ['class_id' => 1, 'user_id' => 6],  // Pedro - 6ºA
            ['class_id' => 1, 'user_id' => 7],  // Mariana - 6ºA
            ['class_id' => 3, 'user_id' => 8],  // Lucas - 7ºA
            ['class_id' => 3, 'user_id' => 9],  // Sofia - 7ºA
            ['class_id' => 5, 'user_id' => 10], // Bruno - 8ºA
            ['class_id' => 5, 'user_id' => 11], // Carla - 8ºA
        ];

        foreach ($classStudents as $relation) {
            DB::table('class_user')->insert(array_merge($relation, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        // class_subject - relaciona turmas com matérias
        $classSubjects = [];
        for ($classId = 1; $classId <= 8; $classId++) {
            for ($subjectId = 1; $subjectId <= 8; $subjectId++) {
                $classSubjects[] = ['class_id' => $classId, 'subject_id' => $subjectId];
            }
        }

        foreach ($classSubjects as $relation) {
            DB::table('class_subject')->insert(array_merge($relation, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        // class_teacher - relaciona turmas com professores (tabela teachers)
        $classTeacherRelations = [
            ['class_id' => 1, 'teacher_id' => 1], // Carlos - 6ºA
            ['class_id' => 2, 'teacher_id' => 1], // Carlos - 6ºB
            ['class_id' => 3, 'teacher_id' => 2], // Ana - 7ºA
            ['class_id' => 4, 'teacher_id' => 2], // Ana - 7ºB
            ['class_id' => 5, 'teacher_id' => 3], // João - 8ºA
            ['class_id' => 6, 'teacher_id' => 3], // João - 8ºB
            ['class_id' => 7, 'teacher_id' => 4], // Maria - 9ºA
            ['class_id' => 8, 'teacher_id' => 4], // Maria - 9ºB
        ];

        foreach ($classTeacherRelations as $relation) {
            DB::table('class_teacher')->insert(array_merge($relation, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}