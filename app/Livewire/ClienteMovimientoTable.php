<?php

namespace App\Livewire;

use App\Exports\ClientesExport;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Cliente;
use App\Models\Movimiento;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;
use Maatwebsite\Excel\Facades\Excel;

class ClienteMovimientoTable extends DataTableComponent
{

    public cliente $cliente;
    // protected $model = Cliente::class; //es lo mismo pero generico

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
                ->format(
                    fn ($value, $row, Column $column) => '<strong>$ ' . number_format($row->monto, 2, '.', ',') . '</strong>'
                )
                ->html(),
            Column::make("REF", "ref")
                ->sortable()
                ->collapseOnTablet()
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
                ->collapseOnTablet()
                ->searchable(),
            Column::make("CUENTA", "cuenta.nombre")
                ->sortable()
                ->collapseAlways()
                ->searchable(),
            Column::make("CLIENTE", "cliente.nombre")
                ->sortable()
                ->collapseAlways()
                ->searchable(),

                Column::make("NOTA", "descripcion")
                ->sortable()
                ->collapseAlways()
                ->searchable(),

            Column::make("CREACION", "created_at")
                ->collapseAlways()
                ->sortable()
                ->format(fn($value)=>$value->format('d/m/y')),
            Column::make("ACTUALIZADO", "updated_at")
                ->collapseAlways()
                ->sortable()
                ->format(fn($value)=>$value->format('d/m/y')),

            Column::make("CREADO POR", "user.name")
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
            ->with('Cliente')
            ->where('cliente_id', $this->cliente->id);
    }

    public  function deleteSelected()
    {
        if ($this->getSelected()) {
            $clientes = Movimiento::whereIn('id', $this->getSelected())->delete();

            $this->clearSelected();
            // $this->emit('Atencion', 'El registro fue eliminado correctamente');


        } else {
            $this->emit('error', 'NO hay registro seleccionado');
        }
    }
    public function exportSelected()
    {
        if ($this->getSelected()) {

            $clientes = Movimiento::whereIn('id', $this->getSelected())->get();
            $this->clearSelected();
            return Excel::download(new ClientesExport($clientes), 'clientes.xlsx');
        } else {
            // return Excel::download(new ClientesExport($this->getRows()), 'clientes.xlsx');
        }
    }
}
