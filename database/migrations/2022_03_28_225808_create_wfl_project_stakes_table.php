<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWflProjectStakesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wfl_project_stakes', function (Blueprint $table) {
            $table->bigInteger('id_prs')->primary();
            $table->bigInteger('stakes_leader_id_prs')->nullable();
            $table->bigInteger('project_id_prs')->nullable();
            $table->smallInteger('deleted_prs')->default(0);
            $table->dateTime('createdon_prs')->nullable();
            $table->bigInteger('createdby_prs')->nullable();
            $table->dateTime('editedon_prs')->default('2018-01-01 01:00:00');
            $table->bigInteger('editedby_prs')->nullable();
            
            $table->foreign('stakes_leader_id_prs', 'FK_3F59C90A5691E7F')->references('id_stl')->on('wfl_stakes_team_leader');
            $table->foreign('project_id_prs', 'FK_3F59C90AF6B589A0')->references('id_pro')->on('wfl_projects');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wfl_project_stakes');
    }
}
