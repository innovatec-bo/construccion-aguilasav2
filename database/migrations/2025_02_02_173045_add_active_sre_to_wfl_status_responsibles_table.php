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
        Schema::table('wfl_status_responsibles', function (Blueprint $table) {
            $table->boolean('active_sre')->default(true)->after('status_id_sre');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wfl_status_responsibles', function (Blueprint $table) {
            $table->dropColumn(['active_sre']);
        });
    }
};
