<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignsToBuiBuildersInManpowerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bui_builders_in_manpower', function (Blueprint $table) {
            $table->foreign('labor_cost_log_id_bim')->references('id_lal')->on('bui_labor_cost_log');
            $table->foreign('user_id_bim')->references('id_usr')->on('sec_users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bui_builders_in_manpower', function (Blueprint $table) {
            $table->dropForeign(['labor_cost_log_id_bim']);
            $table->dropForeign(['user_id_bim']);
        });
    }
}
