<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWflProductionLimitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wfl_production_limits', function (Blueprint $table) {
            $table->bigInteger('id_prl')->primary();
            $table->bigInteger('project_id_prl')->nullable();
            $table->decimal('limit_prl', 8, 2)->default(110.00);
            $table->dateTime('start_date_prl')->nullable();
            $table->dateTime('end_date_prl')->nullable();
            $table->smallInteger('deleted_prl')->default(0);
            $table->dateTime('createdon_prl')->nullable();
            $table->bigInteger('createdby_prl')->nullable();
            $table->dateTime('editedon_prl')->default('2018-01-01 01:00:00');
            $table->bigInteger('editedby_prl')->nullable();
            
            $table->foreign('project_id_prl', 'FK_12910BCE7BBD8455')->references('id_pro')->on('wfl_projects');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wfl_production_limits');
    }
}
