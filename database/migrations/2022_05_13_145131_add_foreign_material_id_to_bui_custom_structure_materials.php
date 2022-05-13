<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignMaterialIdToBuiCustomStructureMaterials extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bui_custom_structure_materials', function (Blueprint $table) {
            $table->foreign('material_id_csm')->references('id_mat')->on('mat_materials');
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
            $table->dropForeign(['material_id_csm']);
        });
    }
}
