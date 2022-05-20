<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignsToBuiLaborCostLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bui_labor_cost_log', function (Blueprint $table) {
            $table->foreign('user_id_lal')->references('id_usr')->on('sec_users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bui_labor_cost_log', function (Blueprint $table) {
            $table->dropForeign(['user_id_lal']);
        });
    }
}
