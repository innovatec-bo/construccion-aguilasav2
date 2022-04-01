<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWflPaymentOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wfl_payment_orders', function (Blueprint $table) {
            $table->bigInteger('id_pao')->primary();
            $table->string('order_number_pao', 20)->nullable();
            $table->smallInteger('status_pao')->nullable();
            $table->text('invoice_number_pao')->nullable();
            $table->dateTime('entry_date_pao')->nullable();
            $table->text('detail_pao')->nullable();
            $table->dateTime('invoice_date_pao')->nullable();
            $table->bigInteger('end_contract_id_pao')->nullable();
            $table->smallInteger('deleted_pao')->default(0);
            $table->dateTime('createdon_pao')->nullable();
            $table->bigInteger('createdby_pao')->nullable();
            $table->dateTime('editedon_pao')->nullable();
            $table->bigInteger('editedby_pao')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wfl_payment_orders');
    }
}
