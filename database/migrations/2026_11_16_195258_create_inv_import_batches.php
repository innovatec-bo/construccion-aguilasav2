<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inv_import_batches', function (Blueprint $t) {
            $t->id();
            $t->string('code', 20)->unique();            // el mismo valor que inv_movements.import_batch
            $t->char('fingerprint', 64)->index();        // huella del CONTENIDO de la planilla (no del archivo)
            $t->string('file_name', 255)->nullable();
            $t->unsignedInteger('movements_count')->default(0);
            $t->unsignedInteger('lines_count')->default(0);
            $t->string('status', 10)->default('active'); // active | voided
            $t->unsignedBigInteger('imported_by')->nullable();
            $t->timestamp('voided_at')->nullable();
            $t->unsignedBigInteger('voided_by')->nullable();
            $t->string('void_reason', 255)->nullable();
            $t->timestamps();
            $t->index(['fingerprint', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inv_import_batches');
    }
};