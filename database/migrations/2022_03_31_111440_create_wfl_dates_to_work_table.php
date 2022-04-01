<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWflDatesToWorkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wfl_dates_to_work', function (Blueprint $table) {
            $table->bigInteger('id_wpl')->primary();
            $table->bigInteger('project_id_wpl')->nullable();
            $table->string('title_wpl', 100)->nullable();
            $table->date('work_date_wpl')->nullable();
            $table->text('detail_wpl')->nullable();
            $table->smallInteger('deleted_wpl')->default(0);
            $table->dateTime('createdon_wpl')->nullable();
            $table->bigInteger('createdby_wpl')->nullable();
            $table->dateTime('editedon_wpl')->nullable();
            $table->bigInteger('editedby_wpl')->nullable();
            
            $table->foreign('project_id_wpl', 'FK_F921F22B4CC4F052')->references('id_pro')->on('wfl_projects');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wfl_dates_to_work');
    }
}
