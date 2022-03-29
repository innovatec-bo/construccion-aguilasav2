<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatProjectsMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mat_projects_materials', function (Blueprint $table) {
            $table->bigInteger('id_prm')->primary();
            $table->bigInteger('materials_summary_id_prm')->nullable()->index('fk_materials_summary_id_prm');
            $table->bigInteger('material_id_prm')->nullable()->index('fk_material_id_prm');
            $table->decimal('quantity_prm', 10, 2)->nullable();
            $table->bigInteger('status_id_prm')->nullable()->index('fk_status_id_prm');
            $table->smallInteger('tension_id_prm')->nullable();
            $table->smallInteger('deleted_prm')->default(0);
            $table->dateTime('createdon_prm')->nullable();
            $table->bigInteger('createdby_prm')->nullable();
            $table->dateTime('editedon_prm')->default('2018-01-01 01:00:00');
            $table->bigInteger('editedby_prm')->nullable();
            $table->text('request_cre_pto_prm')->nullable();
            $table->text('request_cre_detail_prm')->nullable();
            $table->text('delivered_to_builder_detail_prm')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mat_projects_materials');
    }
}
