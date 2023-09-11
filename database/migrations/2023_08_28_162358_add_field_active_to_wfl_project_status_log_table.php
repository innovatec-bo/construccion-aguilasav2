<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldActiveToWflProjectStatusLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wfl_project_status_log', function (Blueprint $table) {
            $table->boolean('active')->default(false)->after('manual_entry_date_psl');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wfl_project_status_log', function (Blueprint $table) {
            $table->dropColumn(['active']);
        });
    }
}
