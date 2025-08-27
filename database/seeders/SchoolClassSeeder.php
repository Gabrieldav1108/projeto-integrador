<?php

namespace Database\Seeders;

use App\Models\SchoolClass;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SchoolClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SchoolClass::truncate();

        $turmas = [
            [
                'name' => 'Turma A - Manhã',
                'numberClass' => '1'
            ],
            [
                'name' => 'Turma B - Tarde', 
                'numberClass' => '2'
            ],
            [
                'name' => 'Turma C - Manhã',
                'numberClass' => '3'
            ],
            [
                'name' => 'Turma D - Tarde',
                'numberClass' => '4'
            ],
            [
                'name' => 'Turma E - Integral',
                'numberClass' => '5'
            ],
            [
                'name' => 'Turma F - Manhã',
                'numberClass' => '6'
            ],
            [
                'name' => 'Turma G - Tarde',
                'numberClass' => '7'
            ]
        ];

        foreach ($turmas as $turma) {
            SchoolClass::create($turma);
        }

        $this->command->info('7 turmas de teste criadas com sucesso!');
        $this->command->info('Turmas disponíveis:');
        foreach ($turmas as $turma) {
            $this->command->info("- {$turma['name']} ({$turma['numberClass']})");
        }
    }
}
