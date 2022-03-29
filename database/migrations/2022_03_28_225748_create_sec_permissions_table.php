<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSecPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sec_permissions', function (Blueprint $table) {
            $table->bigInteger('id_per')->primary()->unique();
            $table->bigInteger('featureid_per')->nullable();
            $table->bigInteger('roleid_per')->nullable();
            $table->smallInteger('deleted_per')->default(0);
            $table->dateTime('createdon_per')->nullable();
            $table->bigInteger('createdby_per')->nullable();
            $table->dateTime('editedon_per')->default('2018-01-01 01:00:00');
            $table->bigInteger('editedby_per')->nullable();
            
            $table->foreign('featureid_per', 'FK_73305C18D0F3307F')->references('id_fes')->on('sec_features');
            $table->foreign('roleid_per', 'FK_73305C18EE71D259')->references('id_rol')->on('sec_roles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sec_permissions');
    }
}
