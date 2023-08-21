<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('StatusManagement.enable_manual_approvement_for_conciliations', true);
    }
};
