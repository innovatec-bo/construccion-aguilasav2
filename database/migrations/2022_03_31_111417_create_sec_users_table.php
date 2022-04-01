<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSecUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sec_users', function (Blueprint $table) {
            $table->bigInteger('id_usr')->primary()->unique();
            $table->string('firstname_usr', 40)->nullable();
            $table->string('lastname_usr', 40)->nullable();
            $table->string('email_usr', 40)->nullable();
            $table->string('facebookid_usr', 40)->nullable();
            $table->string('phone_usr', 20)->nullable();
            $table->text('password_usr')->nullable();
            $table->bigInteger('avatar_usr')->nullable();
            $table->text('passwordhash_usr')->nullable();
            $table->text('activationhash_usr')->nullable();
            $table->smallInteger('status_usr')->nullable();
            $table->smallInteger('tax_deductible_usr')->nullable();
            $table->string('googleid_usr', 40)->nullable();
            $table->bigInteger('supervising_user_usr')->nullable();
            $table->double('umbo_usr')->nullable();
            $table->smallInteger('deleted_usr')->default(0);
            $table->dateTime('createdon_usr')->nullable();
            $table->bigInteger('createdby_usr')->nullable();
            $table->dateTime('editedon_usr')->nullable();
            $table->bigInteger('editedby_usr')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sec_users');
    }
}
