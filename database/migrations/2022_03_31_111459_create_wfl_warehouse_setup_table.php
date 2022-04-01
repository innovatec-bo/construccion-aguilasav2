<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWflWarehouseSetupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wfl_warehouse_setup', function (Blueprint $table) {
            $table->bigInteger('id_wsu')->primary()->unique();
            $table->smallInteger('deleted_wsu')->default(0);
            $table->dateTime('createdon_wsu')->nullable();
            $table->bigInteger('createdby_wsu')->nullable();
            $table->dateTime('editedon_wsu')->nullable();
            $table->bigInteger('editedby_wsu')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wfl_warehouse_setup');
    }
}
