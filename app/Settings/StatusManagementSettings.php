<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class StatusManagementSettings extends Settings
{

    public bool $enable_manual_approvement_for_conciliations;
    public bool $no_pending_materials_in_cre_for_as_built;
    
    public static function group(): string
    {
        return 'StatusManagement';
    }
}