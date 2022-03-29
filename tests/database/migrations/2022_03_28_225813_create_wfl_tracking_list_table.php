<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWflTrackingListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wfl_tracking_list', function (Blueprint $table) {
            $table->bigInteger('id_trl')->primary();
            $table->string('list_name_trl', 40)->nullable();
            $table->text('code_list_trl')->nullable();
            $table->smallInteger('deleted_trl')->default(0);
            $table->dateTime('createdon_trl')->nullable();
            $table->bigInteger('createdby_trl')->nullable();
            $table->dateTime('editedon_trl')->default('2018-01-01 01:00:00');
            $table->bigInteger('editedby_trl')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wfl_tracking_list');
    }
}
