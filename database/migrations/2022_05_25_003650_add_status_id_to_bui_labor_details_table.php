<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusIdToBuiLaborDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('bui_labor_details', function (Blueprint $table) {
            $table->bigInteger('status_id_lad')->after('destiny_lad')->nullable();
            $table->foreign('status_id_lad', 'fk_status_id_lad')->references('id_pst')->on('wfl_project_status');
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
        Schema::table('bui_labor_details', function (Blueprint $table) {
            $table->dropForeign('fk_status_id_lad');
            $table->dropColumn('status_id_lad');
        });
        Schema::enableForeignKeyConstraints();
    }
}
