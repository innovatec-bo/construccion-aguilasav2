<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWflProjectStatusFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wfl_project_status_files', function (Blueprint $table) {
            $table->bigInteger('id_psf')->primary();
            $table->bigInteger('status_log_id_psf')->nullable();
            $table->bigInteger('project_id_psf')->nullable();
            $table->bigInteger('status_id_psf')->nullable();
            $table->bigInteger('file_id_psf')->nullable();
            $table->smallInteger('deleted_psf')->default(0);
            $table->dateTime('createdon_psf')->nullable();
            $table->bigInteger('createdby_psf')->nullable();
            $table->dateTime('editedon_psf')->default('2018-01-01 01:00:00');
            $table->bigInteger('editedby_psf')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wfl_project_status_files');
    }
}
