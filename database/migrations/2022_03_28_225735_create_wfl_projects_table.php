<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWflProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wfl_projects', function (Blueprint $table) {
            $table->bigInteger('id_pro')->primary()->unique();
            $table->bigInteger('status_pro')->nullable();
            $table->bigInteger('contract_id_pro')->nullable();
            $table->string('code_pro', 15)->nullable();
            $table->string('project_name_pro', 100)->nullable();
            $table->bigInteger('system_pro')->nullable();
            $table->string('address_pro', 50)->nullable();
            $table->dateTime('entry_date_pro')->nullable();
            $table->bigInteger('cre_fiscal_pro')->nullable();
            $table->dateTime('project_start_pro')->nullable();
            $table->dateTime('project_end_pro')->nullable();
            $table->smallInteger('points_pro')->nullable();
            $table->double('distance_pro')->nullable();
            $table->bigInteger('management_by_pro')->nullable();
            $table->smallInteger('quality_level_pro')->nullable();
            $table->dateTime('cre_design_completion_date_pro')->nullable();
            $table->dateTime('cre_building_completion_date_pro')->nullable();
            $table->integer('budgetary_position_pro')->nullable();
            $table->string('secondary_code_pro', 15)->nullable();
            $table->dateTime('folder_date_pro')->nullable();
            $table->text('detail_pro')->nullable();
            $table->smallInteger('energized_pro')->nullable();
            $table->integer('project_percentage_pro')->nullable();
            $table->string('latitude_pro', 50)->nullable();
            $table->string('longitude_pro', 50)->nullable();
            $table->string('work_area_pro', 20)->nullable();
            $table->string('project_year_pro', 10)->nullable();
            $table->bigInteger('end_contract_pro')->nullable();
            $table->smallInteger('deleted_pro')->default(0);
            $table->dateTime('createdon_pro')->nullable();
            $table->bigInteger('createdby_pro')->nullable();
            $table->dateTime('editedon_pro')->default('2018-01-01 01:00:00');
            $table->bigInteger('editedby_pro')->nullable();
            $table->double('initial_design_budget_pro')->nullable();
            $table->double('initial_building_budget_pro')->nullable();
            
            $table->foreign('status_pro', 'FK_CCE7F4FBB5DB865D')->references('id_pst')->on('wfl_project_status');
            $table->foreign('contract_id_pro', 'FK_CCE7F4FBC950DBE8')->references('id_con')->on('wfl_contracts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wfl_projects');
    }
}
