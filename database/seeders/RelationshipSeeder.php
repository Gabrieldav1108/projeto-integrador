<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RelationshipSeeder extends Seeder
{
    public function run(): void
    {
        // class_user - relaciona professores com turmas (buscando usuários por email)
        $teacherAssignments = [
            'carlos.silva@escola.com' => [1,2,3,4],
            'ana.santos@escola.com' => [1,2,3,4,5,6,7,8],
            'joao.pereira@escola.com' => [5,6,7,8],
            'maria.oliveira@escola.com' => [1,2,7,8],
        ];

        foreach ($teacherAssignments as $email => $classIds) {
            $user = DB::table('users')->where('email', $email)->first();
            if (!$user) {
                Log::warning("Teacher user not found for email: {$email}");
                continue;
            }

            foreach ($classIds as $classId) {
                DB::table('class_user')->insert([
                    'class_id' => $classId,
                    'user_id' => $user->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // class_user - relaciona alunos (buscar users por email)
        $studentAssignments = [
            'pedro.costa@escola.com' => 1,
            'mariana.lima@escola.com' => 1,
            'lucas.almeida@escola.com' => 3,
            'sofia.rodrigues@escola.com' => 3,
            'bruno.santos@escola.com' => 5,
            'carla.mendes@escola.com' => 5,
        ];

        foreach ($studentAssignments as $email => $classId) {
            $user = DB::table('users')->where('email', $email)->first();
            if (!$user) {
                Log::warning("Student user not found for email: {$email}");
                continue;
            }

            DB::table('class_user')->insert([
                'class_id' => $classId,
                'user_id' => $user->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
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
        // class_teacher - relaciona turmas com professores (buscar teachers por email)
        $teacherClassMap = [
            'carlos.silva@escola.com' => [1,2],
            'ana.santos@escola.com' => [3,4],
            'joao.pereira@escola.com' => [5,6],
            'maria.oliveira@escola.com' => [7,8],
        ];

        foreach ($teacherClassMap as $email => $classIds) {
            $teacher = DB::table('teachers')->where('email', $email)->first();
            if (!$teacher) {
                Log::warning("Teacher record not found for email: {$email}");
                continue;
            }

            foreach ($classIds as $classId) {
                DB::table('class_teacher')->insert([
                    'class_id' => $classId,
                    'teacher_id' => $teacher->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}