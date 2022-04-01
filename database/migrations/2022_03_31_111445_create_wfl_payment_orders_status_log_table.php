<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWflPaymentOrdersStatusLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wfl_payment_orders_status_log', function (Blueprint $table) {
            $table->bigInteger('id_pos')->primary();
            $table->bigInteger('status_id_pos')->nullable();
            $table->bigInteger('payment_order_id_pos')->nullable();
            $table->text('log_detail_pos')->nullable();
            $table->dateTime('manual_entry_date_pos')->nullable();
            $table->smallInteger('deleted_pos')->default(0);
            $table->dateTime('createdon_pos')->nullable();
            $table->bigInteger('createdby_pos')->nullable();
            $table->dateTime('editedon_pos')->nullable();
            $table->bigInteger('editedby_pos')->nullable();
            
            $table->foreign('status_id_pos', 'FK_2EF7CA83A337A6BB')->references('id_pst')->on('wfl_project_status');
            $table->foreign('payment_order_id_pos', 'FK_2EF7CA83BB02A939')->references('id_pao')->on('wfl_payment_orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wfl_payment_orders_status_log');
    }
}
