<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatInternalWarehouseOperationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mat_internal_warehouse_operations', function (Blueprint $table) {
            $table->bigInteger('id_iwo')->primary();
            $table->dateTime('entry_date_iwo')->nullable();
            $table->text('detail_iwo')->nullable();
            $table->smallInteger('deleted_iwo')->default(0);
            $table->dateTime('createdon_iwo')->nullable();
            $table->bigInteger('createdby_iwo')->nullable();
            $table->dateTime('editedon_iwo')->nullable();
            $table->bigInteger('editedby_iwo')->nullable();
            $table->bigInteger('operation_type_id_iwo')->nullable();
            $table->bigInteger('fiscal_id_iwo')->nullable();
            $table->bigInteger('builder_id_iwo')->nullable();
            $table->bigInteger('project_id_iwo')->nullable();
            
            $table->foreign('builder_id_iwo', 'FK_903EFF9F2BA4335C')->references('id_usr')->on('sec_users');
            $table->foreign('operation_type_id_iwo', 'FK_903EFF9F406B0021')->references('id_oty')->on('mat_internal_warehouse_operation_types');
            $table->foreign('fiscal_id_iwo', 'FK_903EFF9F7A1AD4E8')->references('id_usr')->on('sec_users');
            $table->foreign('project_id_iwo', 'FK_903EFF9F8C34B955')->references('id_pro')->on('wfl_projects');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mat_internal_warehouse_operations');
    }
}
