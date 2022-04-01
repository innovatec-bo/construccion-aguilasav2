<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MigrateUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = DB::table('sec_users')->get();
        $data = [];
        foreach ($users as $user) 
        {
            $data[] = [
                        'first_name' => $user->firstname_usr,
                        'last_name' => is_null($user->lastname_usr)?"":$user->lastname_usr,
                        'email' => $user->deleted_usr == 1?"deleted_".$user->id_usr:$user->email_usr,
                        'password' => bcrypt($user->email_usr),
                        'umbo' => $user->umbo_usr
            ];
        }
        User::insert($data);
    }
}
