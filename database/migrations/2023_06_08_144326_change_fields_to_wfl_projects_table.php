<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeFieldsToWflProjectsTable extends Migration
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
            $table->bigInteger('system_pro')->unsigned()->change();
            $table->bigInteger('management_by_pro')->unsigned()->change();
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
            $table->bigInteger('system_pro')->unsigned()->change();
            $table->bigInteger('management_by_pro')->unsigned()->change();
        });
        Schema::enableForeignKeyConstraints();
    }
}
