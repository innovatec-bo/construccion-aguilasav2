<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuiPointToPointMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bui_point_to_point_master', function (Blueprint $table) {
            $table->bigInteger('id_ptp')->primary();
            $table->string('project_code_ptp', 20)->nullable();
            $table->string('point_ptp', 15)->nullable();
            $table->string('latitude_ptp', 30)->nullable();
            $table->string('longitude_ptp', 30)->nullable();
            $table->string('reg_ptp', 5)->nullable();
            $table->string('previous_point_ptp', 15)->nullable();
            $table->double('distance_at_ptp')->nullable();
            $table->double('angle_at_ptp')->nullable();
            $table->double('distance_mt_ptp')->nullable();
            $table->double('angle_mt_ptp')->nullable();
            $table->double('distance_bt_ptp')->nullable();
            $table->double('angle_bt_ptp')->nullable();
            $table->string('activity_ptp', 5)->nullable();
            $table->decimal('quantity_ptp', 8, 2)->nullable();
            $table->string('building_structure_code_ptp', 10)->nullable();
            $table->string('execution_ptp', 5)->nullable();
            $table->string('unit_of_measurement_ptp', 15)->nullable();
            $table->text('building_structure_detail_ptp')->nullable();
            $table->smallInteger('deleted_ptp')->default(0);
            $table->dateTime('createdon_ptp')->nullable();
            $table->bigInteger('createdby_ptp')->nullable();
            $table->dateTime('editedon_ptp')->nullable();
            $table->bigInteger('editedby_ptp')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bui_point_to_point_master');
    }
}
