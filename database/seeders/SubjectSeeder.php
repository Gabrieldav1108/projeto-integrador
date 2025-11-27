<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        $subjects = [
            ['name' => 'Matemática', 'description' => 'Álgebra, geometria e cálculo'],
            ['name' => 'Português', 'description' => 'Gramática e literatura'],
            ['name' => 'História', 'description' => 'História geral e do Brasil'],
            ['name' => 'Geografia', 'description' => 'Geografia física e humana'],
            ['name' => 'Ciências', 'description' => 'Biologia, física e química'],
            ['name' => 'Inglês', 'description' => 'Língua inglesa'],
            ['name' => 'Educação Física', 'description' => 'Atividades físicas e esportes'],
            ['name' => 'Artes', 'description' => 'Artes visuais e música'],
        ];

        foreach ($subjects as $subject) {
            DB::table('subjects')->insert([
                'name' => $subject['name'],
                'description' => $subject['description'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}