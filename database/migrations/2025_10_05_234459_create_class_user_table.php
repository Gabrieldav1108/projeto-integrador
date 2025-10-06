<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('class_user')) {
            Schema::create('class_user', function (Blueprint $table) {
                $table->id();
                $table->foreignId('class_id')->constrained('classes')->onDelete('cascade');
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->timestamps();
                
                $table->unique(['class_id', 'user_id']);
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('class_user');
    }
};