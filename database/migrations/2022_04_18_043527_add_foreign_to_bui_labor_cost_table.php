<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignToBuiLaborCostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('bui_labor_cost', function (Blueprint $table) {
            $table->foreign('labor_detail_id_lac','fk_labor_detail_id_lac')->references('id_lad')->on('bui_labor_details');
            $table->foreign('building_structure_id_lac','fk_building_structure_id_lac')->references('id_bus')->on('bui_building_structures');
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
        Schema::table('bui_labor_cost', function (Blueprint $table) {
            $table->dropForeign('fk_labor_detail_id_lac');
            $table->dropForeign('fk_building_structure_id_lac');
        });
        Schema::enableForeignKeyConstraints();
    }
}
