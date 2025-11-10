<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_grades_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('subject_id')->constrained()->onDelete('cascade');
            $table->enum('trimester', ['first_trimester', 'second_trimester', 'third_trimester']);
            $table->string('assessment_name');
            $table->decimal('grade', 4, 2); // 10.00 format
            $table->integer('weight')->default(1);
            $table->date('assessment_date')->nullable();
            $table->timestamps();

            $table->unique(['student_id', 'subject_id', 'trimester', 'assessment_name']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('grades');
    }
};