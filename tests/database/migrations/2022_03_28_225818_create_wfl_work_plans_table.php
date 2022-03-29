<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWflWorkPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wfl_work_plans', function (Blueprint $table) {
            $table->bigInteger('id_wpl')->primary();
            $table->text('title_wpl')->nullable();
            $table->bigInteger('fiscal_id_wpl')->nullable();
            $table->bigInteger('builder_id_wpl')->nullable();
            $table->smallInteger('week_number_wpl')->nullable();
            $table->smallInteger('deleted_wpl')->default(0);
            $table->dateTime('createdon_wpl')->nullable();
            $table->bigInteger('createdby_wpl')->nullable();
            $table->dateTime('editedon_wpl');
            $table->bigInteger('editedby_wpl')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wfl_work_plans');
    }
}
