<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuiBuildingPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bui_building_points', function (Blueprint $table) {
            $table->bigInteger('id_bpo')->primary();
            $table->bigInteger('project_id_bpo')->nullable();
            $table->string('label_bpo', 30)->nullable();
            $table->string('latitude_bpo', 30)->nullable();
            $table->string('longitude_bpo', 30)->nullable();
            $table->bigInteger('previous_point_bpo')->nullable();
            $table->decimal('distance_bpo', 8, 2)->nullable();
            $table->decimal('angle_bpo', 8, 2)->nullable();
            $table->smallInteger('deleted_bpo')->default(0);
            $table->dateTime('createdon_bpo')->nullable();
            $table->bigInteger('createdby_bpo')->nullable();
            $table->dateTime('editedon_bpo')->default('2018-01-01 01:00:00');
            $table->bigInteger('editedby_bpo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bui_building_points');
    }
}
