<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class MigrateRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = DB::table('sec_roles')->get();
        $superAdmin = Role::where('name','Super admin')->first();
        
        $data = [];
        foreach ($roles as $role) 
        {
            if($role->rolename_rol == "Super admin" && !is_null($superAdmin))
            {
                continue;
            }
            
            $data[] = [
                    'name' => $role->rolename_rol,
                    'guard_name' => 'web',
                ];
        }
        Role::insert($data);
    }
}
