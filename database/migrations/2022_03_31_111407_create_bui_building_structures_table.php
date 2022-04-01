<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuiBuildingStructuresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bui_building_structures', function (Blueprint $table) {
            $table->bigInteger('id_bus')->primary();
            $table->string('structure_code_bus', 30)->nullable();
            $table->text('description_bus')->nullable();
            $table->string('unit_of_measurement_bus', 20)->nullable();
            $table->smallInteger('budget_type_bus')->nullable();
            $table->smallInteger('deleted_bus')->default(0);
            $table->dateTime('createdon_bus')->nullable();
            $table->bigInteger('createdby_bus')->nullable();
            $table->dateTime('editedon_bus')->nullable();
            $table->bigInteger('editedby_bus')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bui_building_structures');
    }
}
