<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatMaterialStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mat_material_status', function (Blueprint $table) {
            $table->bigInteger('id_mst')->primary();
            $table->string('detail_mst', 100)->nullable();
            $table->string('code_mst', 20)->nullable();
            $table->smallInteger('deleted_mst')->default(0);
            $table->dateTime('createdon_mst')->nullable();
            $table->bigInteger('createdby_mst')->nullable();
            $table->dateTime('editedon_mst')->default('2018-01-01 01:00:00');
            $table->bigInteger('editedby_mst')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mat_material_status');
    }
}
