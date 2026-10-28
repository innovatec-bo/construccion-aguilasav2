<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('system.logo', null);
        $this->migrator->add('system.pin_marker', null);
        $this->migrator->add('system.full_logo', null);
        $this->migrator->add('system.favicon', null);
    }
};
