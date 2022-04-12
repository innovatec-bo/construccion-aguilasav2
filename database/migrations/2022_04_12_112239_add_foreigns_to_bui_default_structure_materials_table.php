<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignsToBuiDefaultStructureMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('bui_default_structure_materials', function (Blueprint $table) {
            $table->foreign('structure_id_dsm','fk_structure_id_dsm')->references('id_bus')->on('bui_building_structures');
            $table->foreign('material_id_dsm','fk_material_id_dsm')->references('id_mat')->on('mat_materials');
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
        Schema::table('bui_default_structure_materials', function (Blueprint $table) {
            $table->dropForeign('fk_structure_id_dsm');
            $table->dropForeign('fk_material_id_dsm');
        });
        Schema::enableForeignKeyConstraints();
    }
}
