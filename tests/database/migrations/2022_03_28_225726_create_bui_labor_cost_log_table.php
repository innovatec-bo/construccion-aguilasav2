<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuiLaborCostLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bui_labor_cost_log', function (Blueprint $table) {
            $table->bigInteger('id_lal')->primary();
            $table->bigInteger('user_id_lal')->nullable();
            $table->text('detail_lal')->nullable();
            $table->dateTime('manual_entry_date_lal')->nullable();
            $table->bigInteger('point_id_lal')->nullable();
            $table->smallInteger('deleted_lal')->default(0);
            $table->dateTime('createdon_lal')->nullable();
            $table->bigInteger('createdby_lal')->nullable();
            $table->dateTime('editedon_lal')->default('2018-01-01 01:00:00');
            $table->bigInteger('editedby_lal')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bui_labor_cost_log');
    }
}
