<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration {
    public function up(): void
    {
        // Por defecto en false para que ningún cliente se vea afectado de golpe
        $this->migrator->add('system.enable_detailed_tree_trimming', false);
    }

    public function down(): void
    {
        $this->migrator->deleteIfExists('system.enable_detailed_tree_trimming');
    }
};