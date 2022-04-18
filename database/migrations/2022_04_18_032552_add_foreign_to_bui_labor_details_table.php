<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignToBuiLaborDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('bui_labor_details', function (Blueprint $table) {
            $table->foreign('project_id_lad','fk_project_id_lad')->references('id_pro')->on('wfl_projects');
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
        Schema::table('bui_labor_details', function (Blueprint $table) {
            $table->dropForeign('fk_project_id_lad');
        });
        Schema::enableForeignKeyConstraints();
    }
}
