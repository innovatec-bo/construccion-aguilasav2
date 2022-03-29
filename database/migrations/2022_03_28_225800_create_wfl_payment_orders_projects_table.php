<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWflPaymentOrdersProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wfl_payment_orders_projects', function (Blueprint $table) {
            $table->bigInteger('id_pop')->primary();
            $table->bigInteger('order_id_pop')->nullable();
            $table->bigInteger('project_id_pop')->nullable();
            $table->double('design_budget_pop')->nullable();
            $table->double('transportation_budget_pop')->nullable();
            $table->double('building_budget_pop')->nullable();
            $table->double('live_line_budget_pop')->nullable();
            $table->double('right_of_way_budget_pop')->nullable();
            $table->smallInteger('deleted_pop')->default(0);
            $table->dateTime('createdon_pop')->nullable();
            $table->bigInteger('createdby_pop')->nullable();
            $table->dateTime('editedon_pop')->default('2018-01-01 01:00:00');
            $table->bigInteger('editedby_pop')->nullable();
            
            $table->foreign('order_id_pop', 'FK_74CA6C5144FB4F99')->references('id_pao')->on('wfl_payment_orders');
            $table->foreign('project_id_pop', 'FK_74CA6C5190D0B406')->references('id_pro')->on('wfl_projects');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wfl_payment_orders_projects');
    }
}
