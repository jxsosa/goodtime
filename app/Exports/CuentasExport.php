<?php

namespace App\Exports;

use App\Models\Cuenta;
use Maatwebsite\Excel\Concerns\FromCollection;

class CuentasExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Cuenta::all();
    }
}
