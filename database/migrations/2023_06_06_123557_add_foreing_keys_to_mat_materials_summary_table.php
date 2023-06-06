<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeingKeysToMatMaterialsSummaryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('mat_materials_summary', function (Blueprint $table) {
            $table->foreign('project_status_log_id_msu','fk_project_status_log_id_msu')->references('id_psl')->on('wfl_project_status_log');
            $table->foreign('project_id_msu','fk_project_id_msu')->references('id_pro')->on('wfl_projects');
            $table->foreign('applicant_project_id_msu','fk_applicant_project_id_msu')->references('id_pro')->on('wfl_projects');
            $table->foreign('summary_type_id_msu','fk_summary_type_id_msu')->references('id_mqt')->on('mat_materials_summary_types');
            $table->foreign('file_id_msu','fk_file_id_msu')->references('id_fil')->on('sys_files');
            $table->foreign('fiscal_responsible_msu','fk_fiscal_responsible_msu')->references('id_usr')->on('sec_users');
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('mat_materials_summary', function (Blueprint $table) {
            $table->dropForeign('fk_project_status_log_id_msu');
            $table->dropForeign('fk_project_id_msu');
            $table->dropForeign('fk_applicant_project_id_msu');
            $table->dropForeign('fk_summary_type_id_msu');
            $table->dropForeign('fk_file_id_msu');
            $table->dropForeign('fk_fiscal_responsible_msu');
        });
        Schema::enableForeignKeyConstraints();
    }
}
