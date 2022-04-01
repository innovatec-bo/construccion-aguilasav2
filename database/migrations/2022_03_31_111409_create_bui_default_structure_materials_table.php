<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuiDefaultStructureMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bui_default_structure_materials', function (Blueprint $table) {
            $table->bigInteger('id_dsm')->primary();
            $table->bigInteger('structure_id_dsm')->nullable();
            $table->bigInteger('material_id_dsm')->nullable();
            $table->decimal('quantity_dsm', 8, 2)->nullable();
            $table->smallInteger('deleted_dsm')->default(0);
            $table->dateTime('createdon_dsm')->nullable();
            $table->bigInteger('createdby_dsm')->nullable();
            $table->dateTime('editedon_dsm')->nullable();
            $table->bigInteger('editedby_dsm')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bui_default_structure_materials');
    }
}
