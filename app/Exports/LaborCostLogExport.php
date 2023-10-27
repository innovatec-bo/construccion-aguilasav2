<?php

namespace App\Exports;

use App\Models\LaborDetail;
use App\Models\Project;
use Maatwebsite\Excel\Concerns\FromCollection;

class LaborCostLogExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $project = Project::find(3567);
        $laborDetail = $project->laborDetailDesign;

        return $laborDetail;
    }
}
