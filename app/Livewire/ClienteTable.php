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

class ClienteTable extends DataTableComponent
{

   
    protected $model = Cliente::class; //es lo mismo pero generico

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setTableRowUrl(function($row){
                return route('admin.cliente.show', [
                    'cliente' => $row->id
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

            Column::make("Correo", "email")
                ->sortable()
                ->searchable()
                ->collapseAlways(),
            
            Column::make("Telefono", "telefono")
                ->sortable()
                ->searchable()
                ->collapseAlways(),
            Column::make('Saldo', "id")
                ->sortable()
                ->searchable()
                ->format(
                    fn($value, $row, Column $column) => $retVal = (number_format($this->montoCliente($row->id), 2, '.', ',')>=0) ? '<strong>' . number_format($this->montoCliente($row->id), 2, '.', ',') . ' $</strong>' : '<strong><i class=" text-danger">' . number_format($this->montoCliente($row->id), 2, '.', ',') . ' $</i>'  .'</strong>'
                   )
                ->html(),

            // Column::make("fecha", "created_at")
            //     ->sortable()
            //     ->searchable()
            //     ->format(fn($value)=>$value->format('d/m/y')),

            Column::make('Acciones')
                ->label(fn($row)=>view('admin.cliente.tables.action', [
                    'id'=> $row->id
                ])),
            ///crear botones en la tabla 
            // ButtonGroupColumn::make('Accion')
            //     ->buttons([
            //         LinkColumn::make('Accion')
            //             ->title(fn()=>'Ver')
            //             ->location(fn($row)=>route('admin.cliente.show', [
            //                 'cliente' => $row->id]))
            //             ->attributes(fn()=>[
            //                 'class' =>'btn btn-info btn-sm'
            //             ]),
            //         LinkColumn::make('Accion')
            //             ->title(fn()=>'Editar')
            //             ->location(fn($row)=>route('admin.cliente.edit', [
            //                 'cliente' => $row->id]))
            //             ->attributes(fn()=>[
            //                 'class' =>'btn btn-primary btn-sm'
            //             ]) 
            //     ])


               
        ];
    }
    //para generar consulta mas compleja
    // public function builder(): Builder
    // {
    //     return Cliente::query()
    //         ->with('Movimiento');
    // }
    
    public  function deleteSelected(){
        if ($this->getSelected()) {
            $clientes= Cliente::whereIn('id', $this->getSelected())->delete();
            
            $this->clearSelected();
            // $this->emit('Atencion', 'El registro fue eliminado correctamente');

            
        }else {
            $this->emit('error', 'NO hay registro seleccionado');
        }

    }
    public function exportSelected(){
        if ($this->getSelected()) {
            
            $clientes= Cliente::whereIn('id', $this->getSelected())->get();
            $this->clearSelected();
            return Excel::download(new ClientesExport($clientes), 'clientes.xlsx');   
        }else {
           // return Excel::download(new ClientesExport($this->getRows()), 'clientes.xlsx');
        }
    }
    public function montoCliente($id){
        $entrada = 0;
        $salida = 0;
        $saldo = 0;
        $bs=0;
        $movimientos=Movimiento::where('cliente_id', '=', $id)->get();

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
        return $saldo;
    }
}

