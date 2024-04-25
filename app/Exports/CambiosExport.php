<?php

namespace App\Exports;

use App\Models\Cambio;
use Maatwebsite\Excel\Concerns\FromCollection;

class CambiosExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Cambio::all();
    }
}
