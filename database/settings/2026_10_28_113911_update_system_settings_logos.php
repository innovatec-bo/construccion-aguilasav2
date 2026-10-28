<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration {
    public function up(): void
    {
        // Eliminamos las anteriores si ya las habías corrido
        $this->migrator->deleteIfExists('system.logo');
        $this->migrator->deleteIfExists('system.full_logo');

        // Agregamos las nuevas con nombres descriptivos
        $this->migrator->add('system.app_logo', null);
        $this->migrator->add('system.document_logo', null);
    }

    public function down(): void
    {
        $this->migrator->deleteIfExists('system.app_logo');
        $this->migrator->deleteIfExists('system.document_logo');

        $this->migrator->add('system.logo', null);
        $this->migrator->add('system.full_logo', null);
    }
};