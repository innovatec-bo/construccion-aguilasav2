<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuiLaborCostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bui_labor_cost', function (Blueprint $table) {
            $table->bigInteger('id_lac')->primary();
            $table->bigInteger('labor_detail_id_lac')->nullable();
            $table->bigInteger('building_structure_id_lac')->nullable();
            $table->string('activity_lac', 5)->nullable();
            $table->string('execution_lac', 5)->nullable();
            $table->decimal('quantity_lac', 8, 2)->nullable();
            $table->decimal('unit_price_lac', 8, 2)->nullable();
            $table->smallInteger('is_additional_lac')->nullable();
            $table->smallInteger('deleted_lac')->default(0);
            $table->dateTime('createdon_lac')->nullable();
            $table->bigInteger('createdby_lac')->nullable();
            $table->dateTime('editedon_lac')->default('2018-01-01 01:00:00');
            $table->bigInteger('editedby_lac')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bui_labor_cost');
    }
}
