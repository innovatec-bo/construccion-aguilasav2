<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWflExternalFiscalObservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wfl_external_fiscal_observations', function (Blueprint $table) {
            $table->bigInteger('id_efo')->primary();
            $table->bigInteger('project_id_efo')->nullable()->index('fk_project_id_efo');
            $table->bigInteger('fiscal_id_efo')->nullable()->index('fk_fiscal_id_efo');
            $table->text('observation_efo')->nullable();
            $table->bigInteger('fixed_by_efo')->nullable()->index('fk_fixed_by_efo');
            $table->text('fix_detail_efo')->nullable();
            $table->dateTime('fixed_date_efo')->nullable();
            $table->bigInteger('status_id_efo')->nullable()->index('fk_status_id_efo');
            $table->dateTime('entry_date_efo')->nullable();
            $table->smallInteger('fixed_efo')->nullable();
            $table->smallInteger('deleted_efo')->default(0);
            $table->dateTime('createdon_efo')->nullable();
            $table->bigInteger('createdby_efo')->nullable();
            $table->dateTime('editedon_efo')->default('2018-01-01 01:00:00');
            $table->bigInteger('editedby_efo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wfl_external_fiscal_observations');
    }
}
