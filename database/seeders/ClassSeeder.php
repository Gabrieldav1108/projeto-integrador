<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassSeeder extends Seeder
{
    public function run(): void
    {
        $classes = [
            ['name' => '6º Ano A', 'numberClass' => 601],
            ['name' => '6º Ano B', 'numberClass' => 602],
            ['name' => '7º Ano A', 'numberClass' => 701],
            ['name' => '7º Ano B', 'numberClass' => 702],
            ['name' => '8º Ano A', 'numberClass' => 801],
            ['name' => '8º Ano B', 'numberClass' => 802],
            ['name' => '9º Ano A', 'numberClass' => 901],
            ['name' => '9º Ano B', 'numberClass' => 902],
        ];

        foreach ($classes as $class) {
            DB::table('classes')->insert([
                'name' => $class['name'],
                'numberClass' => $class['numberClass'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}