<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSecExecutiveSummaryLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sec_executive_summary_log', function (Blueprint $table) {
            $table->bigInteger('id_esl')->primary();
            $table->string('stage_esl', 20)->nullable();
            $table->smallInteger('projects_quantity_esl')->nullable();
            $table->decimal('project_percentage_esl', 10, 2)->nullable();
            $table->decimal('approved_budget_esl', 10, 2)->nullable();
            $table->decimal('approved_budget_percentage_esl', 10, 2)->nullable();
            $table->decimal('contract_percentage_esl', 10, 2)->nullable();
            $table->dateTime('date_esl')->nullable();
            $table->smallInteger('deleted_esl')->default(0);
            $table->dateTime('createdon_esl')->nullable();
            $table->bigInteger('createdby_esl')->nullable();
            $table->dateTime('editedon_esl')->default('2018-01-01 01:00:00');
            $table->bigInteger('editedby_esl')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sec_executive_summary_log');
    }
}
