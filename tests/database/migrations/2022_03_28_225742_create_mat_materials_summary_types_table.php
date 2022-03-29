<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatMaterialsSummaryTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mat_materials_summary_types', function (Blueprint $table) {
            $table->bigInteger('id_mqt')->primary();
            $table->text('name_mqt')->nullable();
            $table->string('keyword_mqt', 50)->nullable();
            $table->string('icon_mqt', 60)->nullable();
            $table->string('movement_type_mqt', 30)->nullable();
            $table->smallInteger('deleted_mqt')->default(0);
            $table->dateTime('createdon_mqt')->nullable();
            $table->bigInteger('createdby_mqt')->nullable();
            $table->dateTime('editedon_mqt')->default('2018-01-01 01:00:00');
            $table->bigInteger('editedby_mqt')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mat_materials_summary_types');
    }
}
