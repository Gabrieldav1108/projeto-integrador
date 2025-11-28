<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassInformationSeeder extends Seeder
{
    public function run(): void
    {
        $infos = [
            [
                'class_id' => 1,
                'subject_id' => 1,
                'content' => 'Aulas semanais toda segunda-feira às 10:00',
                'date' => now()->toDateString(),
                'time' => '10:00:00',
            ],
            [
                'class_id' => 5,
                'subject_id' => 5,
                'content' => 'Levar material para aula prática',
                'date' => now()->addDays(3)->toDateString(),
                'time' => '09:00:00',
            ],
        ];

        foreach ($infos as $i) {
            DB::table('class_information')->insert(array_merge($i, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
