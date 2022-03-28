<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'admin.project.index']);
        Permission::create(['name' => 'admin.project.create']);
        Permission::create(['name' => 'admin.project.update']);
        Permission::create(['name' => 'admin.project.delete']);

        // this can be done as separate statements
        $role = Role::create(['name' => 'Super admin']);
        $role->givePermissionTo(Permission::all());

    }
}
