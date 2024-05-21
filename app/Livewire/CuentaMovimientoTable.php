<?php

namespace App\Livewire;

use App\Exports\CuentasExport;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Cuenta;
use App\Models\Movimiento;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;

class CuentaMovimientoTable extends DataTableComponent
{
    //protected $model = Cuenta::class;
    public Cuenta $cuentum;

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setTableRowUrl(function ($row) {
                return route('admin.movimientos.show', [
                    'movimiento' => $row->id,

                ]);
            });
        $this->setDefaultSort('created_at', 'desc');
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
                ->collapseAlways()
                ->searchable(),
            Column::make("BS", "bs")
                ->sortable()
                ->format(
                    fn ($value, $row, Column $column) => 'Bs ' . number_format($row->bs, 2, '.', ',') . ''
                )
                ->html(),
            Column::make("TASA", "tasa")
                ->sortable(),
            Column::make("MONTO", "monto")
                ->sortable()
                ->searchable()
                ->format(
                    fn ($value, $row, Column $column) => '<strong>$ ' . number_format($row->monto, 2, '.', ',') . '</strong>'
                )
                ->html(),
            Column::make("REF", "ref")
                ->sortable()
                ->collapseAlways()
                ->searchable(),
            Column::make("TIPO", "tipo")
                ->sortable()
                ->searchable()
                ->format(
                    fn ($value, $row, Column $column) => $retVal = ($row->tipo == 'entrada') ? '<i class="fas fa-plus-circle ">' . $row->tipo . '</i>' : '<i class="fas fa-minus-circle text-danger">' . $row->tipo . '</i>'
                )
                ->html(),
            Column::make("ENTERGA", "fecha_entrega")
                ->sortable()
                ->collapseAlways()
                ->searchable()
                ->format(
                    fn ($value, $row, Column $column) => date_format(date_create($row->fecha_entrega), 'd/m/y')
                ),

            Column::make("CAMBIO", "cambio.nombre")
                ->sortable()
                
                ->collapseAlways()
                ->searchable(),
            Column::make("CUENTA", "cuenta.nombre")
                ->sortable()
                ->collapseAlways()
                ->searchable(),
            Column::make("CLIENTE", "cliente.nombre")
                ->sortable()
                ->collapseOnTablet()
                ->searchable(),
            
            Column::make("CREACION", "created_at")

                ->sortable()
                ->format(fn ($value) => $value->format('d/m/y h:m:s')),
            Column::make("NOTA", "descripcion")
                ->sortable()
                ->collapseAlways()
                ->searchable(),
            Column::make('Acciones')
                ->label(fn ($row) => view('admin.movimientos.tables.action', [
                    'id' => $row->id
                ])),
        ];
    }
    //para generar consulta mas compleja
    public function builder(): Builder
    {

        return Movimiento::query()
            ->with('Cuenta')
            ->where('cuenta_id', $this->cuentum->id);
    }

    public  function deleteSelected()
    {
        if ($this->getSelected()) {
            $cuentas = Movimiento::whereIn('id', $this->getSelected())->delete();

            $this->clearSelected();
            // $this->emit('Atencion', 'El registro fue eliminado correctamente');


        } else {
            $this->emit('error', 'NO hay registro seleccionado');
        }
    }
    public function exportSelected()
    {
        if ($this->getSelected()) {

            $cuentas = Movimiento::whereIn('id', $this->getSelected())->get();
            $this->clearSelected();
            return Excel::download(new CuentasExport($cuentas), 'cuentamovimiento.xlsx');
        } else {
            // return Excel::download(new ClientesExport($this->getRows()), 'clientes.xlsx');
        }
    }
}
