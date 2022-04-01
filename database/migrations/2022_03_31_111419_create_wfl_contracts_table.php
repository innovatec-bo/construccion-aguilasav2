<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWflContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wfl_contracts', function (Blueprint $table) {
            $table->bigInteger('id_con')->primary();
            $table->string('contract_number_con', 20)->nullable();
            $table->double('amount_con')->nullable();
            $table->dateTime('start_date_con')->nullable();
            $table->dateTime('expiration_date_con')->nullable();
            $table->smallInteger('deleted_con')->default(0);
            $table->dateTime('createdon_con')->nullable();
            $table->bigInteger('createdby_con')->nullable();
            $table->dateTime('editedon_con')->nullable();
            $table->bigInteger('editedby_con')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wfl_contracts');
    }
}
