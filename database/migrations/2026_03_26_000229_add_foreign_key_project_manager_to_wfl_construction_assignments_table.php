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
        Schema::table('wfl_construction_assignments', function (Blueprint $table) {
            $table->foreign('project_manager_cas')
                ->references('id_usr')
                ->on('sec_users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wfl_construction_assignments', function (Blueprint $table) {
            $table->dropForeign(['project_manager_cas']);
        });
    }
};
