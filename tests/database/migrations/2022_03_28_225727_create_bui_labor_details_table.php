<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuiLaborDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bui_labor_details', function (Blueprint $table) {
            $table->bigInteger('id_lad')->primary();
            $table->bigInteger('project_id_lad')->nullable();
            $table->string('graph_number_lad', 20)->nullable();
            $table->string('level_of_tension_lad', 20)->nullable();
            $table->text('destiny_lad')->nullable();
            $table->smallInteger('deleted_lad')->default(0);
            $table->dateTime('createdon_lad')->nullable();
            $table->bigInteger('createdby_lad')->nullable();
            $table->dateTime('editedon_lad')->default('2018-01-01 01:00:00');
            $table->bigInteger('editedby_lad')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bui_labor_details');
    }
}
