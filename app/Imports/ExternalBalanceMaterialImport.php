<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ExternalBalanceMaterialImport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new ExternalBalanceMaterialDataImport(),
        ];
    }
}
