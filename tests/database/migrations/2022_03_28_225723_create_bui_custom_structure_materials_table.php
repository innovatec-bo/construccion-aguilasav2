<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuiCustomStructureMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bui_custom_structure_materials', function (Blueprint $table) {
            $table->bigInteger('id_csm')->primary();
            $table->bigInteger('structure_id_csm')->nullable();
            $table->bigInteger('material_id_csm')->nullable();
            $table->decimal('quantity_csm', 8, 2)->nullable();
            $table->bigInteger('project_id_csm')->nullable();
            $table->smallInteger('deleted_csm')->default(0);
            $table->dateTime('createdon_csm')->nullable();
            $table->bigInteger('createdby_csm')->nullable();
            $table->dateTime('editedon_csm')->default('2018-01-01 01:00:00');
            $table->bigInteger('editedby_csm')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bui_custom_structure_materials');
    }
}
