<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWflStatusResponsiblesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wfl_status_responsibles', function (Blueprint $table) {
            $table->bigInteger('id_sre')->primary();
            $table->bigInteger('user_id_sre')->nullable();
            $table->bigInteger('status_id_sre')->nullable();
            $table->smallInteger('deleted_sre')->default(0);
            $table->dateTime('createdon_sre')->nullable();
            $table->bigInteger('createdby_sre')->nullable();
            $table->dateTime('editedon_sre')->nullable();
            $table->bigInteger('editedby_sre')->nullable();
            
            $table->foreign('user_id_sre', 'FK_6A19488872D172DF')->references('id_usr')->on('sec_users');
            $table->foreign('status_id_sre', 'FK_6A194888AAC9C1AF')->references('id_pst')->on('wfl_project_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wfl_status_responsibles');
    }
}
