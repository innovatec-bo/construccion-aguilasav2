<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSecUserSupervisorByPeriodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sec_user_supervisor_by_period', function (Blueprint $table) {
            $table->bigInteger('id_usp')->primary();
            $table->bigInteger('user_id_usp')->nullable()->index('fk_user_id_usp');
            $table->bigInteger('supervisor_id_usp')->nullable()->index('fk_supervisor_id_usp');
            $table->dateTime('from_usp')->nullable();
            $table->dateTime('to_usp')->nullable();
            $table->smallInteger('deleted_usp')->default(0);
            $table->dateTime('createdon_usp')->nullable();
            $table->bigInteger('createdby_usp')->nullable();
            $table->dateTime('editedon_usp')->nullable();
            $table->bigInteger('editedby_usp')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sec_user_supervisor_by_period');
    }
}
