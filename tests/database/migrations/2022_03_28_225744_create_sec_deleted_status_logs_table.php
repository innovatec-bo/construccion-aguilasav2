<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSecDeletedStatusLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sec_deleted_status_logs', function (Blueprint $table) {
            $table->bigInteger('id_dsl')->primary();
            $table->bigInteger('deleted_by_dsl')->nullable();
            $table->bigInteger('status_log_id_dsl')->nullable();
            $table->text('detail_dsl')->nullable();
            $table->smallInteger('deleted_dsl')->default(0);
            $table->dateTime('createdon_dsl')->nullable();
            $table->bigInteger('createdby_dsl')->nullable();
            $table->dateTime('editedon_dsl')->default('2018-01-01 01:00:00');
            $table->bigInteger('editedby_dsl')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sec_deleted_status_logs');
    }
}
