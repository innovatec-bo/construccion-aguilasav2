<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWflWorkflowColumnGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wfl_workflow_column_groups', function (Blueprint $table) {
            $table->bigInteger('id_wcg')->primary();
            $table->string('column_group_name_wcg', 20)->nullable();
            $table->text('column_list_wcg')->nullable();
            $table->smallInteger('deleted_wcg')->default(0);
            $table->dateTime('createdon_wcg')->nullable();
            $table->bigInteger('createdby_wcg')->nullable();
            $table->dateTime('editedon_wcg')->default('2018-01-01 01:00:00');
            $table->bigInteger('editedby_wcg')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wfl_workflow_column_groups');
    }
}
