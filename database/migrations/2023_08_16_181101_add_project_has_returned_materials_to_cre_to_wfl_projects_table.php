<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProjectHasReturnedMaterialsToCreToWflProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wfl_projects', function (Blueprint $table) {
            $table->boolean('project_has_returned_materials_to_cre')->default(false)->after('initial_building_budget_pro');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wfl_projects', function (Blueprint $table) {
            $table->dropColumn(['project_has_returned_materials_to_cre']);
        });
    }
}
