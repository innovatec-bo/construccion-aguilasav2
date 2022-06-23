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
            code_pro,
            project_id_psl,
            concat('[',group_concat(concat('{\"id_psl\": ',id_psl,', \"status_id_psl\": ',status_id_psl,', \"id_reb\": ',ifnull(id_reb,'null'),', \"manual_entry_date_psl\": \"',manual_entry_date_psl,'\"}')),']') conciliations,
            id_reb,
            wfl_project_status_log.*
        from 
            wfl_project_status_log 
        left join wfl_project_real_budgets on status_log_id_reb = id_psl
        left join wfl_projects on id_pro = project_id_psl
        where 
        status_id_psl in (34, 35)
        -- and manual_entry_date_psl > '2022-01-01 00:00:00'
        and deleted_psl != 1
        group by project_id_psl
        order by project_id_psl, status_id_psl, manual_entry_date_psl
        ");
        $dataToUpdate = [];
        $withoutReceptions = [];
        $withoutShipments = [];
        foreach ($data as $value) 
        {
            $receptions = [];
            $shipments = [];
            $conciliations = json_decode($value->conciliations, true);
            foreach ($conciliations as $row) 
            {
                if($row['status_id_psl'] == 34)
                    $receptions[] = $row;
                else
                    $shipments[] = $row;
            }
            //Reception
            $receptionDates = array_column($receptions, 'manual_entry_date_psl'); 
            if(count($receptionDates) <= 0)
            {
                $withoutReceptions[] = $value;
                continue;
                // dd($value, $receptionDates);
            }
            $maxReceptionDate = max($receptionDates);
            $maxReceptionDatePosition = array_search($maxReceptionDate, $receptionDates);

            //Shipment
            $shipmentDates = array_column($shipments, 'manual_entry_date_psl'); 
            if(count($shipmentDates) <= 0)
            {
                $withoutShipments[] = $value;
                continue;
            }
            $maxShipmentDate = max($shipmentDates);
            $maxShipmentDatePosition = array_search($maxShipmentDate, $shipmentDates);

            //Data to update
            $dataToUpdate[] = [
                'id_reb' => $shipments[$maxShipmentDatePosition]['id_reb'],
                'status_log_id_reb' => $receptions[$maxReceptionDatePosition]['id_psl']
            ];
        }
        // dd(count($dataToUpdate));
        dd($withoutReceptions, $withoutShipments);
    }
}
