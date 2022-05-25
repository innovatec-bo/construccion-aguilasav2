<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignsToWflProjectBudgetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('wfl_project_budgets', function (Blueprint $table) {
            $table->foreign('manpower_file_id_prb','fk_manpower_file_id_prb')->references('id_fil')->on('sys_files');
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('wfl_project_budgets', function (Blueprint $table) {
            $table->dropForeign('fk_manpower_file_id_prb');
        });
        Schema::enableForeignKeyConstraints();
    }
}
