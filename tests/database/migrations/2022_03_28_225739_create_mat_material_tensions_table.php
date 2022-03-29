<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatMaterialTensionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mat_material_tensions', function (Blueprint $table) {
            $table->bigInteger('id_mte')->primary();
            $table->string('detail_mte', 100)->nullable();
            $table->string('code_mte', 20)->nullable();
            $table->smallInteger('deleted_mte')->default(0);
            $table->dateTime('createdon_mte')->nullable();
            $table->bigInteger('createdby_mte')->nullable();
            $table->dateTime('editedon_mte')->default('2018-01-01 01:00:00');
            $table->bigInteger('editedby_mte')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mat_material_tensions');
    }
}
