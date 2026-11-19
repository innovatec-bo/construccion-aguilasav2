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
        Schema::table('wfl_projects', function (Blueprint $table) {
            $table->string('default_staker',50)->default('Estaqueador predeterminado')->after('code_pro');
        });

        Schema::table('workflows', function (Blueprint $table) {
            $table->string('default_staker',50)->default('Estaqueador predeterminado')->after('stake_responsible');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wfl_projects', function (Blueprint $table) {
            $table->dropColumn('default_staker');
        });

        Schema::table('workflows', function (Blueprint $table) {
            $table->dropColumn('default_staker');
        });
    }
};
