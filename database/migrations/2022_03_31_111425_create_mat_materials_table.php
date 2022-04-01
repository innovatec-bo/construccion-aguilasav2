<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mat_materials', function (Blueprint $table) {
            $table->bigInteger('id_mat')->primary();
            $table->string('code_mat', 30)->nullable();
            $table->text('name_mat')->nullable();
            $table->text('description_mat')->nullable();
            $table->string('unit_of_measurement_mat', 20)->nullable();
            $table->smallInteger('deleted_mat')->default(0);
            $table->dateTime('createdon_mat')->nullable();
            $table->bigInteger('createdby_mat')->nullable();
            $table->dateTime('editedon_mat')->nullable();
            $table->bigInteger('editedby_mat')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mat_materials');
    }
}
