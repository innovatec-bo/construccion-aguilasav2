<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWflProcessLineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wfl_process_line', function (Blueprint $table) {
            $table->bigInteger('id_prl')->primary();
            $table->bigInteger('project_id_prl')->nullable();
            $table->bigInteger('user_id_prl')->nullable();
            $table->dateTime('start_date_prl')->nullable();
            $table->dateTime('due_date_prl')->nullable();
            $table->text('detail_prl')->nullable();
            $table->smallInteger('deleted_prl')->default(0);
            $table->dateTime('createdon_prl')->nullable();
            $table->bigInteger('createdby_prl')->nullable();
            $table->dateTime('editedon_prl')->default('2018-01-01 01:00:00');
            $table->bigInteger('editedby_prl')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wfl_process_line');
    }
}
