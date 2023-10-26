<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaborCostChangeLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('labor_cost_change_logs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('labor_cost_id')->nullable();
            $table->decimal('quantity_applied');
            $table->decimal('quantity_from');
            $table->decimal('quantity_to');
            $table->timestamps();
            $table->softDeletes();
            $table->blameable();

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
        Schema::dropIfExists('labor_cost_change_logs');
    }
}
