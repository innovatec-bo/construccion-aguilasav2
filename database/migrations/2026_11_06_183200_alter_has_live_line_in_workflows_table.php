<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('workflows', function (Blueprint $table) {
            // Se modifica la columna para admitir valores nulos
            $table->boolean('has_live_line')
                  ->nullable()
                  ->default(null)
                  ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('workflows', function (Blueprint $table) {
            // Revertir a no nulo con valor 0 por defecto
            $table->boolean('has_live_line')
                  ->default(false)
                  ->nullable(false)
                  ->change();
        });
    }
};