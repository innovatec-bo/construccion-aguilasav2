<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuiStructureByPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bui_structure_by_points', function (Blueprint $table) {
            $table->bigInteger('id_sbp')->primary();
            $table->bigInteger('project_id_sbp')->nullable();
            $table->string('label_sbp', 30)->nullable();
            $table->bigInteger('point_id_sbp')->nullable();
            $table->decimal('quantity_to_use_sbp', 8, 2)->nullable();
            $table->bigInteger('labor_cost_id_sbp')->nullable();
            $table->smallInteger('is_additional_sbp')->nullable();
            $table->smallInteger('deleted_sbp')->default(0);
            $table->dateTime('createdon_sbp')->nullable();
            $table->bigInteger('createdby_sbp')->nullable();
            $table->dateTime('editedon_sbp')->nullable();
            $table->bigInteger('editedby_sbp')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bui_structure_by_points');
    }
}
