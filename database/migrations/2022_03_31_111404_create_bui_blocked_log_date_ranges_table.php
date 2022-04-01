<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuiBlockedLogDateRangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bui_blocked_log_date_ranges', function (Blueprint $table) {
            $table->bigInteger('id_bld')->primary();
            $table->dateTime('from_bld')->nullable();
            $table->dateTime('to_bld')->nullable();
            $table->string('deleted_by_bld', 255)->nullable();
            $table->smallInteger('deleted_bld')->default(0);
            $table->dateTime('createdon_bld')->nullable();
            $table->bigInteger('createdby_bld')->nullable();
            $table->dateTime('editedon_bld')->nullable();
            $table->bigInteger('editedby_bld')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bui_blocked_log_date_ranges');
    }
}
