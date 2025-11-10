<?php
// database/migrations/xxxx_xx_xx_xxxxxx_remove_weight_from_grades_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('grades', function (Blueprint $table) {
            $table->dropColumn('weight');
        });
    }

    public function down()
    {
        Schema::table('grades', function (Blueprint $table) {
            $table->integer('weight')->default(1);
        });
    }
};