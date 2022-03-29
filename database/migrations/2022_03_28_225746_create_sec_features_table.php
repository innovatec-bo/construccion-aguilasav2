<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSecFeaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sec_features', function (Blueprint $table) {
            $table->bigInteger('id_fes')->primary()->unique();
            $table->string('featurename_fes', 40)->nullable();
            $table->string('securitystring_fes', 50)->nullable();
            $table->string('featureicon_fes', 30)->nullable();
            $table->string('link_fes', 70)->nullable();
            $table->text('description_fes')->nullable();
            $table->bigInteger('parent_feature_id_fes')->nullable();
            $table->smallInteger('order_fes')->nullable();
            $table->smallInteger('is_menu_fes')->default(1);
            $table->smallInteger('deleted_fes')->default(0);
            $table->dateTime('createdon_fes')->nullable();
            $table->bigInteger('createdby_fes')->nullable();
            $table->dateTime('editedon_fes')->default('2018-01-01 01:00:00');
            $table->bigInteger('editedby_fes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sec_features');
    }
}
