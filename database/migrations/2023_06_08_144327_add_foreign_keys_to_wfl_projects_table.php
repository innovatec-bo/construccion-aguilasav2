<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToWflProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('wfl_projects', function (Blueprint $table) {
            $table->foreign('system_pro','fk_system_pro')->references('id')->on('project_systems');
            $table->foreign('management_by_pro','fk_management_by_pro')->references('id')->on('project_management');
            $table->foreign('cre_fiscal_pro','fk_cre_fiscal_pro')->references('id_usr')->on('sec_users');
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
        Schema::table('wfl_projects', function (Blueprint $table) {
            $table->dropForeign('fk_system_pro');
            $table->dropForeign('fk_management_by_pro');
            $table->dropForeign('fk_cre_fiscal_pro');
        });
        Schema::enableForeignKeyConstraints();
    }
}
