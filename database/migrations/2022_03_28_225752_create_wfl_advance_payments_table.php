<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWflAdvancePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wfl_advance_payments', function (Blueprint $table) {
            $table->bigInteger('id_apa')->primary();
            $table->bigInteger('project_id_apa')->nullable();
            $table->dateTime('entry_date_apa')->nullable();
            $table->decimal('amount_apa', 10, 2)->nullable();
            $table->text('detail_apa')->nullable();
            $table->smallInteger('deleted_apa')->default(0);
            $table->dateTime('createdon_apa')->nullable();
            $table->bigInteger('createdby_apa')->nullable();
            $table->dateTime('editedon_apa')->default('2018-01-01 01:00:00');
            $table->bigInteger('editedby_apa')->nullable();
            
            $table->foreign('project_id_apa', 'FK_AC8704562ADE532D')->references('id_pro')->on('wfl_projects');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wfl_advance_payments');
    }
}
