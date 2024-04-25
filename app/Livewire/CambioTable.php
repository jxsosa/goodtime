<?php

namespace App\Livewire;

use App\Exports\CambiosExport;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Cambio;
use App\Models\Movimiento;
use Maatwebsite\Excel\Facades\Excel;

class CambioTable extends DataTableComponent
{
    protected $model = Cambio::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setTableRowUrl(function ($row) {
                return route('admin.cambios.show', [
                    'cambio' => $row->id
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

            Column::make('Entrada', "id")
                ->sortable()
                ->searchable()
                ->format(
                    fn ($value, $row, Column $column) => '$ ' . number_format($this->montoCambio($row->id)["entrada"], 2, '.', ',') . ''
                )
                ->html(),
            Column::make('Salida', "id")
                ->sortable()
                ->searchable()
                ->format(
                    fn ($value, $row, Column $column) => '$ ' . number_format($this->montoCambio($row->id)["salida"], 2, '.', ',') . ''
                )
                ->html(),

            Column::make('Saldo', "id")
                ->sortable()
                ->searchable()
                ->format(
                    fn ($value, $row, Column $column) => '<strong>$ ' . number_format($this->montoCambio($row->id)["saldo"], 2, '.', ',') . '</strong>'
                )
                ->html(),

            Column::make('Acciones')
                ->label(fn ($row) => view('admin.cambios.tables.action', [
                    'id' => $row->id
                ])),
        ];
    }
    public  function deleteSelected()
    {
        if ($this->getSelected()) {
            $cambios = Cambio::whereIn('id', $this->getSelected())->delete();

            $this->clearSelected();
            // $this->emit('Atencion', 'El registro fue eliminado correctamente');


        } else {
            $this->emit('error', 'NO hay registro seleccionado');
        }
    }
    public function exportSelected()
    {
        if ($this->getSelected()) {

            $cambios = Cambio::whereIn('id', $this->getSelected())->get();
            $this->clearSelected();
            return Excel::download(new CambiosExport($cambios), 'cambios.xlsx');
        } else {
            // return Excel::download(new ClientesExport($this->getRows()), 'clientes.xlsx');
        }
    }
    public function montoCambio($id)
    {
        $entrada = 0;
        $salida = 0;
        $saldo = 0;
        $bs = 0;
        $movimientos = Movimiento::where('cambio_id', '=', $id)->get();

        foreach ($movimientos as $movimiento) {
            if ($movimiento->tipo == 'entrada') {
                $entrada = $entrada + $movimiento->monto;
                $bs = $bs + $movimiento->bs;
            }
            if ($movimiento->tipo == 'salida') {
                $salida = $salida + $movimiento->monto;
                $bs = $bs - $movimiento->bs;
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
