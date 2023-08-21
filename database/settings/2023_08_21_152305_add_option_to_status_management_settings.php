<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('StatusManagement.no_pending_materials_in_cre_for_as_built', true);
    }
};
