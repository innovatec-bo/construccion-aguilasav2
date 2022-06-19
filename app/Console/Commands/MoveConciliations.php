<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MoveConciliations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'conciliations:move';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Move al budgets from conciliation shipment to conciliation reception';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {//Actualizar los budgets y asignar el status log id correcto(el de recepcion de conciliacion)
        $data = DB::select("
        select
        project_id_psl,
        concat('[',
            group_concat(JSON_OBJECT(
                'id_psl', id_psl,
                'status_id_psl', status_id_psl,
                'id_reb', id_reb
            )
        ,']')
        )
        id_reb,
            wfl_project_status_log.*
        from 
            wfl_project_status_log 
        left join wfl_project_real_budgets on status_log_id_reb = id_psl
        where 
        status_id_psl in (34, 35)
        and manual_entry_date_psl > '2022-01-01 00:00:00' 
        group by project_id_psl
        order by project_id_psl, status_id_psl, manual_entry_date_psl
        ");
        dd($data);
    }
}
