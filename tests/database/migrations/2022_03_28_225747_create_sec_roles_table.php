<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSecRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sec_roles', function (Blueprint $table) {
            $table->bigInteger('id_rol')->primary()->unique();
            $table->string('rolename_rol', 20)->nullable();
            $table->string('keyword_rol', 30)->nullable();
            $table->smallInteger('deleted_rol')->default(0);
            $table->dateTime('createdon_rol')->nullable();
            $table->bigInteger('createdby_rol')->nullable();
            $table->dateTime('editedon_rol')->default('2018-01-01 01:00:00');
            $table->bigInteger('editedby_rol')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sec_roles');
    }
}
