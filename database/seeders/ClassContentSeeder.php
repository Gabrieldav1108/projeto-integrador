<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassContentSeeder extends Seeder
{
    public function run(): void
    {
        $contents = [
            [
                'title' => 'Introdução à Álgebra',
                'description' => 'Resumo dos conceitos básicos',
                'file_path' => null,
                'content' => 'Variáveis, expressões e equações.',
                'type' => 'text',
                'class_id' => 1,
                'subject_id' => 1,
                'teacher_id' => 1,
            ],
            [
                'title' => 'Vídeo - Sistema Solar',
                'description' => 'Aula em vídeo sobre o sistema solar',
                'file_path' => null,
                'content' => 'https://example.com/video-sistema-solar',
                'type' => 'video',
                'class_id' => 5,
                'subject_id' => 5,
                'teacher_id' => 4,
            ],
        ];

        foreach ($contents as $c) {
            DB::table('class_contents')->insert(array_merge($c, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
