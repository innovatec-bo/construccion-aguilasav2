<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWflProjectStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wfl_project_status', function (Blueprint $table) {
            $table->bigInteger('id_pst')->primary()->unique();
            $table->string('status_name_pst', 50)->nullable();
            $table->string('status_icon_pst', 50)->nullable();
            $table->smallInteger('order_pst')->nullable();
            $table->bigInteger('parent_status_pst')->nullable();
            $table->string('keyword_pst', 50)->nullable();
            $table->smallInteger('deleted_pst')->default(0);
            $table->dateTime('createdon_pst')->nullable();
            $table->bigInteger('createdby_pst')->nullable();
            $table->dateTime('editedon_pst')->nullable();
            $table->bigInteger('editedby_pst')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wfl_project_status');
    }
}
