<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatMaterialsSummaryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mat_materials_summary', function (Blueprint $table) {
            $table->bigInteger('id_msu')->primary();
            $table->bigInteger('project_status_log_id_msu')->nullable()->index('fk_project_status_log_id_msu');
            $table->string('tension_level_msu', 50)->nullable();
            $table->bigInteger('project_id_msu')->nullable()->index('fk_project_id_msu');
            $table->bigInteger('applicant_project_id_msu')->nullable()->index('fk_applicant_project_id_msu');
            $table->string('graph_number_msu', 30)->nullable();
            $table->string('destiny_msu', 100)->nullable();
            $table->dateTime('entry_date_msu')->nullable();
            $table->text('detail_msu')->nullable();
            $table->bigInteger('builder_responsible_msu')->nullable();
            $table->bigInteger('summary_type_id_msu')->nullable()->index('fk_summary_type_id_msu');
            $table->string('reservation_number_msu', 30)->nullable();
            $table->bigInteger('file_id_msu')->nullable();
            $table->bigInteger('parent_summary_id_msu')->nullable()->index('fk_parent_summary_id_msu');
            $table->smallInteger('is_loan_msu')->nullable();
            $table->smallInteger('loan_closed_msu')->nullable();
            $table->dateTime('loan_closed_date_msu')->nullable();
            $table->integer('correlative_counter_msu')->nullable();
            $table->bigInteger('fiscal_responsible_msu')->nullable();
            $table->smallInteger('deleted_msu')->default(0);
            $table->dateTime('createdon_msu')->nullable();
            $table->bigInteger('createdby_msu')->nullable();
            $table->dateTime('editedon_msu')->nullable();
            $table->bigInteger('editedby_msu')->nullable();
            $table->smallInteger('status_id_msu')->nullable();
            $table->dateTime('canceled_on_msu')->nullable();
            $table->dateTime('withdrawn_on_msu')->nullable();
            $table->bigInteger('canceledby_msu')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mat_materials_summary');
    }
}
