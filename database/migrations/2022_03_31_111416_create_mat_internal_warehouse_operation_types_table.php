<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatInternalWarehouseOperationTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mat_internal_warehouse_operation_types', function (Blueprint $table) {
            $table->bigInteger('id_oty')->primary();
            $table->text('name_oty')->nullable();
            $table->string('keyword_oty', 50)->nullable();
            $table->string('icon_oty', 60)->nullable();
            $table->string('operation_type_oty', 30)->nullable();
            $table->smallInteger('deleted_oty')->default(0);
            $table->dateTime('createdon_oty')->nullable();
            $table->bigInteger('createdby_oty')->nullable();
            $table->dateTime('editedon_oty')->nullable();
            $table->bigInteger('editedby_oty')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mat_internal_warehouse_operation_types');
    }
}
