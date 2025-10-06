<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('subjects', function (Blueprint $table) {
            // Adicionar coluna name se não existir
            if (!Schema::hasColumn('subjects', 'name')) {
                $table->string('name')->after('id');
            }
            
            // Adicionar coluna description se não existir
            if (!Schema::hasColumn('subjects', 'description')) {
                $table->text('description')->nullable()->after('name');
            }
        });
    }

    public function down()
    {
        Schema::table('subjects', function (Blueprint $table) {
            // Remover as colunas se necessário
            $table->dropColumn(['name', 'description']);
        });
    }
};