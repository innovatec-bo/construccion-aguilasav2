<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AsignCreFiscalRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fiscals = "
        81
        85
        31
        32
        73
        33
        34
        35
        36
        37
        38
        39
        40
        41
        86
        43
        44
        45
        46
        47
        84
        48
        49
        50
        51
        52
        70
        53
        68
        60
        79
        62
        54
        55
        56
        57
        58
        59
        ";
        $list = $fiscals;
        $list = str_replace("\r\n"," ", $list);
        $list = explode(PHP_EOL, $list);
        $list = array_values(array_filter($list));
        foreach ($list as $key => &$fiscal)
        {
            if($key == 38)
            {
                unset($list[$key]);
            }
            else
            {
                $fiscal = trim($fiscal);
            }
        }

        $users = User::whereIn('id_usr', $list)->get();
        foreach ($users as $user) 
        {
            $user->syncRoles(['Fiscal de CRE']);
        }
    }
}
