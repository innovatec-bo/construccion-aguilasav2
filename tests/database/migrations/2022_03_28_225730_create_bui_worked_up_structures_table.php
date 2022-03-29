<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuiWorkedUpStructuresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bui_worked_up_structures', function (Blueprint $table) {
            $table->bigInteger('id_wus')->primary();
            $table->bigInteger('labor_cost_log_id_wus')->nullable();
            $table->bigInteger('labor_cost_id_wus')->nullable();
            $table->decimal('worked_up_wus', 8, 2)->nullable();
            $table->decimal('price_wus', 8, 2)->nullable();
            $table->smallInteger('deleted_wus')->default(0);
            $table->dateTime('createdon_wus')->nullable();
            $table->bigInteger('createdby_wus')->nullable();
            $table->dateTime('editedon_wus')->default('2018-01-01 01:00:00');
            $table->bigInteger('editedby_wus')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bui_worked_up_structures');
    }
}
