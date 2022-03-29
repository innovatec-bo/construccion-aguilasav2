<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatInternalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mat_internals', function (Blueprint $table) {
            $table->bigInteger('id_int')->primary();
            $table->bigInteger('material_id_int')->nullable();
            $table->decimal('quantity_int', 10, 2)->nullable();
            $table->bigInteger('status_id_int')->nullable();
            $table->smallInteger('tension_id_int')->nullable();
            $table->smallInteger('deleted_int')->default(0);
            $table->dateTime('createdon_int')->nullable();
            $table->bigInteger('createdby_int')->nullable();
            $table->dateTime('editedon_int')->default('2018-01-01 01:00:00');
            $table->bigInteger('editedby_int')->nullable();
            $table->bigInteger('operation_id_int')->nullable();
            
            $table->foreign('operation_id_int', 'FK_97BD5973F7758B89')->references('id_iwo')->on('mat_internal_warehouse_operations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mat_internals');
    }
}
