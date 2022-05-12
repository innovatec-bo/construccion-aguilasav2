<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLaborCostIdToCustomStructureMaterials extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bui_custom_structure_materials', function (Blueprint $table) {
            $table->bigInteger('labor_cost_id')->nullable()->after('structure_id_csm');
            $table->foreign('labor_cost_id')->references('id_lac')->on('bui_labor_cost');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bui_custom_structure_materials', function (Blueprint $table) {
            $table->dropForeign(['labor_cost_id']);
            $table->dropColumn('labor_cost_id');
        });
    }
}
