<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSecUserrolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sec_userroles', function (Blueprint $table) {
            $table->bigInteger('id_uro')->primary()->unique();
            $table->bigInteger('roleid_uro')->nullable();
            $table->bigInteger('userid_uro')->nullable();
            $table->smallInteger('deleted_uro')->default(0);
            $table->dateTime('createdon_uro')->nullable();
            $table->bigInteger('createdby_uro')->nullable();
            $table->dateTime('editedon_uro')->default('2018-01-01 01:00:00');
            $table->bigInteger('editedby_uro')->nullable();
            
            $table->foreign('roleid_uro', 'FK_4E0166978E3FF8FD')->references('id_rol')->on('sec_roles');
            $table->foreign('userid_uro', 'FK_4E0166979B21EB8A')->references('id_usr')->on('sec_users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sec_userroles');
    }
}
