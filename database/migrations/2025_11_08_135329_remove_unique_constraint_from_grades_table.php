<?php
// database/migrations/xxxx_xx_xx_xxxxxx_remove_unique_constraint_from_grades_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('grades', function (Blueprint $table) {
            // Remover a constraint única
            $table->dropUnique(['student_id', 'subject_id', 'trimester', 'assessment_name']);
        });
    }

    public function down()
    {
        Schema::table('grades', function (Blueprint $table) {
            // Recriar a constraint única se necessário
            $table->unique(['student_id', 'subject_id', 'trimester', 'assessment_name']);
        });
    }
};