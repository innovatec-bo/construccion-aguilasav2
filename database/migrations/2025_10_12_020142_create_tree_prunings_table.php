<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tree_prunings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('budget_id');
            $table->foreign('budget_id')->references('id_prb')->on('wfl_project_budgets')->cascadeOnDelete();
            $table->unsignedSmallInteger('tree_number')->nullable()->comment('Tree number');
            // $table->string('species')->nullable()->comment('Specie of tree');
            $table->foreignId('species_id')->nullable()->comment('Specie of tree')->constrained('tree_species', 'id')->nullOnDelete();
            $table->decimal('utm_x', 10, 2)->nullable()->comment('Coordinate UTM X');
            $table->decimal('utm_y', 10, 2)->nullable()->comment('Coordinate UTM Y');

            $table->string('neighborhood')->nullable()->comment('Neighborhood');
            $table->string('neighborhood_unit')->nullable()->comment('Neighborhood unit');
            $table->string('block', 50)->nullable()->comment('Neighborhood block');
            $table->string('district', 50)->nullable()->comment('District');

            $table->tinyInteger('quality')->nullable()->comment('Quality 1,2,3');
            $table->string('pruning_type', 100)->nullable()->comment('Pruning type: balanced, etc.');
            $table->boolean('has_agreement')->default(false)->comment('true = has agreement, false = without agreement');

            $table->text('notes')->nullable()->comment('Observations');
            $table->date('pruned_at')->nullable()->comment('Date that was made the pruning');

            $table->timestamps();
            $table->softDeletes();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tree_prunings');
    }
};
