<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBaseTableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('base_table', function (Blueprint $table) {
            $table->bigInteger('id_')->primary();
            $table->smallInteger('deleted_')->default(0);
            $table->dateTime('createdon_')->nullable();
            $table->bigInteger('createdby_')->nullable();
            $table->dateTime('editedon_')->default('2018-01-01 01:00:00');
            $table->bigInteger('editedby')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('base_table');
    }
}
