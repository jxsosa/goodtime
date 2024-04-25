<?php

namespace App\Livewire;

use App\Exports\CuentasExport;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Cuenta;
use App\Models\Movimiento;
use Maatwebsite\Excel\Facades\Excel;

class CuentaTable extends DataTableComponent
{
    protected $model = Cuenta::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setTableRowUrl(function ($row) {
                return route('admin.cuentas.show', [
                    'cuentum' => $row->id
                ]);
            });

        $this->setSingleSortingDisabled();
        $this->setBulkActions([
            'deleteSelected' => 'Eliminar',
            'exportSelected' => 'Exportar'
        ]);
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable()
                ->collapseOnTablet(),
            Column::make("Nombre", "nombre")
                ->sortable()
                ->searchable(),

            Column::make('Saldo', "id")
                ->sortable()
                ->searchable()
                ->format(
                    fn ($value, $row, Column $column) => '<strong>$ ' . number_format($this->montoCuenta($row->id)['saldo'], 2, '.', ',') . '</strong>'
                )
                ->html(),
             Column::make('TASA', "id")
                ->sortable()
                ->searchable()
                ->format(
                    fn ($value, $row, Column $column) => '<strong>' . number_format($this->montoCuenta($row->id)['bs']/$this->montoCuenta($row->id)['saldo'], 2, '.', ',') . '</strong>'
                )
                ->html(),

                Column::make('BS', "id")
                ->sortable()
                ->searchable()
                ->format(
                    fn ($value, $row, Column $column) => '<strong>Bs ' . number_format($this->montoCuenta($row->id)['bs'], 2, '.', ',') . '</strong>'
                )
                ->html(),

            Column::make('Acciones')
                ->label(fn ($row) => view('admin.cuentas.tables.action', [
                    'id' => $row->id
                ])),
        ];
    }
    public  function deleteSelected()
    {
        if ($this->getSelected()) {
            $cuentas = Cuenta::whereIn('id', $this->getSelected())->delete();

            $this->clearSelected();
            // $this->emit('Atencion', 'El registro fue eliminado correctamente');


        } else {
            $this->emit('error', 'NO hay registro seleccionado');
        }
    }
    public function exportSelected()
    {
        if ($this->getSelected()) {

            $cuentas = Cuenta::whereIn('id', $this->getSelected())->get();
            $this->clearSelected();
            return Excel::download(new CuentasExport($cuentas), 'cuentas.xlsx');
        } else {
            // return Excel::download(new ClientesExport($this->getRows()), 'clientes.xlsx');
        }
    }
    public function montoCuenta($id)
    {
        $entrada = 0;
        $salida = 0;
        $saldo = 0;
        $bs = 0;
        $movimientos = Movimiento::where('cuenta_id', '=', $id)->get();

        foreach ($movimientos as $movimiento) {
            if ($movimiento->tipo == 'entrada') {
                $entrada = $entrada + $movimiento->monto;
                $bs = $bs + $movimiento->bs;
            }
            if ($movimiento->tipo == 'salida') {
                $salida = $salida + $movimiento->monto;
                $bs = $bs -  $movimiento->bs;
            }
        }
        $saldo = $entrada - $salida;
        $MontoTotal = [
            'entrada' => $entrada,
            'salida' => $salida,
            'bs' => $bs,
            'saldo' => $saldo,
        ];
        return $MontoTotal;
    }
}
