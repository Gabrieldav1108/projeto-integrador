<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    public function run()
    {
        $subjects = [
            ['name' => 'Matemática', 'description' => 'Cálculo e álgebra'],
            ['name' => 'Português', 'description' => 'Gramática e literatura'],
            ['name' => 'História', 'description' => 'História geral e do Brasil'],
            ['name' => 'Geografia', 'description' => 'Geografia física e humana'],
            ['name' => 'Ciências', 'description' => 'Biologia e química'],
            ['name' => 'Física', 'description' => 'Física geral'],
            ['name' => 'Química', 'description' => 'Química geral'],
            ['name' => 'Inglês', 'description' => 'Língua inglesa'],
            ['name' => 'Educação Física', 'description' => 'Atividades físicas'],
            ['name' => 'Artes', 'description' => 'Artes visuais e plásticas'],
            ['name' => 'Informática', 'description' => 'Programação e TI'],
            ['name' => 'Filosofia', 'description' => 'Filosofia geral'],
            ['name' => 'Sociologia', 'description' => 'Sociologia geral'],
        ];

        foreach ($subjects as $subject) {
            Subject::create($subject);
        }
    }
}