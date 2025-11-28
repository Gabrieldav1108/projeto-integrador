<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GradesSeeder extends Seeder
{
    public function run(): void
    {
        $grades = [
            [
                'student_id' => 6, // Pedro
                'subject_id' => 1,
                'trimester' => 'first_trimester',
                'assessment_name' => 'Prova 1',
                'grade' => 8.5,
                'assessment_date' => now()->subDays(10)->toDateString(),
            ],
            [
                'student_id' => 7, // Mariana
                'subject_id' => 1,
                'trimester' => 'first_trimester',
                'assessment_name' => 'Prova 1',
                'grade' => 7.0,
                'assessment_date' => now()->subDays(10)->toDateString(),
            ],
        ];

        foreach ($grades as $g) {
            DB::table('grades')->insert(array_merge($g, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
