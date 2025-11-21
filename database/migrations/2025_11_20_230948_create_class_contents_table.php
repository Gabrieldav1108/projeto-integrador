<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('class_contents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('file_path')->nullable();
            $table->text('content')->nullable();
            $table->enum('type', ['text', 'pdf', 'video', 'link']);
            $table->foreignId('class_id')->constrained('classes')->onDelete('cascade');
            $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade');
            $table->foreignId('teacher_id')->constrained('teachers')->onDelete('cascade');
            $table->timestamps();
            
            // Índices para melhor performance
            $table->index(['class_id', 'subject_id']);
            $table->index('teacher_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('class_contents');
    }
};