<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWflStatusLineManagementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wfl_status_line_management', function (Blueprint $table) {
            $table->bigInteger('id_')->primary();
            $table->smallInteger('deleted_')->default(0);
            $table->dateTime('createdon_')->nullable();
            $table->bigInteger('createdby_')->nullable();
            $table->dateTime('editedon_')->nullable();
            $table->bigInteger('editedby_')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wfl_status_line_management');
    }
}
