<?php

namespace App\Imports;

use App\Models\ExternalBalanceMaterial;
use Maatwebsite\Excel\Concerns\ToModel;

class ExternalBalanceMaterialImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new ExternalBalanceMaterial([
            //
        ]);
    }
}
