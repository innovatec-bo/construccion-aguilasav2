<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWflUserUbmosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wfl_user_ubmos', function (Blueprint $table) {
            $table->bigInteger('id_uub')->primary();
            $table->bigInteger('user_id_uub')->nullable();
            $table->bigInteger('contract_id_uub')->nullable();
            $table->decimal('ubmo_uub', 8, 2)->nullable();
            $table->decimal('bs_uub', 8, 2)->nullable();
            $table->smallInteger('deleted_uub')->default(0);
            $table->dateTime('createdon_uub')->nullable();
            $table->bigInteger('createdby_uub')->nullable();
            $table->dateTime('editedon_uub')->nullable();
            $table->bigInteger('editedby_uub')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wfl_user_ubmos');
    }
}
