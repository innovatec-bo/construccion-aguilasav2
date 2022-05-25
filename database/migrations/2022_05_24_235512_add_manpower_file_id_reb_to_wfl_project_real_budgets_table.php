<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddManpowerFileIdRebToWflProjectRealBudgetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wfl_project_real_budgets', function (Blueprint $table) {
            $table->bigInteger('manpower_file_id_reb')->after('right_of_way_reb')->nullable();
            $table->foreign('manpower_file_id_reb','fk_manpower_file_id_reb')->references('id_fil')->on('sys_files');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wfl_project_real_budgets', function (Blueprint $table) {
            $table->dropForeign('fk_manpower_file_id_reb');
            $table->dropColumn(['manpower_file_id_reb']);
        });
    }
}
