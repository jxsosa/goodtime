<?php

namespace App\Exports;

use App\Models\Cliente;
use Maatwebsite\Excel\Concerns\FromCollection;

class ClientesExport implements FromCollection
{

    public $clientes;

    public function __construct($clientes)
    {
        $this->clientes=$clientes;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // return Cliente::all();

        return $this->clientes;
    }
}
