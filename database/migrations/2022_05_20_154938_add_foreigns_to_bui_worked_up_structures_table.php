<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignsToBuiWorkedUpStructuresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bui_worked_up_structures', function (Blueprint $table) {
            $table->foreign('labor_cost_log_id_wus')->references('id_lal')->on('bui_labor_cost_log');
            $table->foreign('labor_cost_id_wus')->references('id_lac')->on('bui_labor_cost');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bui_worked_up_structures', function (Blueprint $table) {
            $table->dropForeign(['labor_cost_log_id_wus']);
            $table->dropForeign(['labor_cost_id_wus']);
        });
    }
}
