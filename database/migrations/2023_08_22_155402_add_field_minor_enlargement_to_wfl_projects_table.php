<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldMinorEnlargementToWflProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wfl_projects', function (Blueprint $table) {
            $table->string('minor_enlargement',2)->nullable()->default(null)->after('project_has_returned_materials_to_cre');
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
            $table->dropColumn(['minor_enlargement']);
        });
    }
}
