<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWflStakesTeamLeaderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wfl_stakes_team_leader', function (Blueprint $table) {
            $table->bigInteger('id_stl')->primary();
            $table->string('leader_stl', 20)->nullable();
            $table->smallInteger('deleted_stl')->default(0);
            $table->dateTime('createdon_stl')->nullable();
            $table->bigInteger('createdby_stl')->nullable();
            $table->dateTime('editedon_stl')->default('2018-01-01 01:00:00');
            $table->bigInteger('editedby_stl')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wfl_stakes_team_leader');
    }
}
