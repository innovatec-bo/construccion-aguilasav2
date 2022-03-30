<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ExportOldData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sql = public_path('data.sql');
          
        $db = [
            'username' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'host' => env('DB_HOST'),
            'database' => env('DB_DATABASE')
        ];
  
        exec("mysqldump --user={$db['username']} --password={$db['password']} --no-tablespaces --complete-insert --no-create-info --host={$db['host']} {$db['database']} > $sql");
  
        \Log::info('SQL Export Done');
    }
}
