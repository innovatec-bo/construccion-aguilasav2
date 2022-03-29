<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_files', function (Blueprint $table) {
            $table->bigInteger('id_fil')->primary()->unique();
            $table->string('uploadfilename_fil', 60)->nullable();
            $table->string('filename_fil', 50)->nullable();
            $table->string('filepath_fil', 50)->nullable();
            $table->string('extension_fil', 6)->nullable();
            $table->integer('size_fil')->nullable();
            $table->integer('height_fil')->nullable();
            $table->integer('width_fil')->nullable();
            $table->integer('mimetype_fil')->nullable();
            $table->text('hash_fil')->nullable();
            $table->text('url_fil')->nullable();
            $table->smallInteger('deleted_fil')->default(0);
            $table->dateTime('createdon_fil')->nullable();
            $table->bigInteger('createdby_fil')->nullable();
            $table->dateTime('editedon_fil')->default('2018-01-01 01:00:00');
            $table->bigInteger('editedby_fil')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_files');
    }
}
