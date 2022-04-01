<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWflCreFiscalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wfl_cre_fiscal', function (Blueprint $table) {
            $table->bigInteger('id_cfi')->primary();
            $table->string('firstname_cfi', 30)->nullable();
            $table->string('lastname_cfi', 30)->nullable();
            $table->smallInteger('deleted_cfi')->default(0);
            $table->dateTime('createdon_cfi')->nullable();
            $table->bigInteger('createdby_cfi')->nullable();
            $table->dateTime('editedon_cfi')->nullable();
            $table->bigInteger('editedby_cfi')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wfl_cre_fiscal');
    }
}
