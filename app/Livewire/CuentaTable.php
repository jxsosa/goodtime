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


            Column::make('TASA', "id")
                ->sortable()
                ->searchable()
                ->format(
                    fn ($value, $row, Column $column) => '<strong>' . $tasa =  number_format($this->montoCuenta($row->id)['tasa'], 2, '.', ',')   . '</strong>'
                )
                ->html(),
            Column::make('Saldo', "id")
                ->sortable()
                ->searchable()
                ->format(
                    fn ($value, $row, Column $column) => '<strong>$ ' . $saldo = number_format($this->montoCuenta($row->id)['saldo'], 2, '.', ',') . '</strong>'
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
        $tasa = 0;
        $monto = 0;
        $MontoTasa=0;
        $EntradaBs=0;
        $movimientos = Movimiento::where('cuenta_id', '=', $id)->get();
        $cuentas=Cuenta::find($id);

        //var_dump( $cuentas);
        foreach ($movimientos as $movimiento) {
            if ($movimiento->tipo == 'entrada') {
                if ((substr_compare($movimiento->cuenta->nombre, 'EFECTIVO', 0, 7)) === 0) {
                    $entrada = $entrada + $movimiento->monto;
                }if ((substr_compare($movimiento->cuenta->nombre, 'ZELLE', 0, 4)) === 0) {
                    $entrada = $entrada + $movimiento->monto;
                }
                if (substr_compare($movimiento->cuenta->nombre, 'USDT', 0, 3) === 0) {
                    $entrada = $entrada + $movimiento->monto;
                    $tasa = $movimiento->tasa;
                } else {
                    $tasa = $movimiento->tasa;
                    if ($movimiento->tasa != 0) {

                        $monto = ($movimiento->bs) / $movimiento->tasa;
                        $EntradaBs = $EntradaBs + $movimiento->bs;
                        $MontoTasa=$MontoTasa+($movimiento->bs/$movimiento->tasa);
                    } else {
                        $monto = '0';
                    }
                    $entrada = $entrada + $monto;
                    
                    //
                   
                }

                //$entrada = $entrada + $movimiento->monto;
                $bs = $bs + $movimiento->bs;
            }
            if ($movimiento->tipo == 'salida') {
                if ((substr_compare($movimiento->cuenta->nombre, 'EFECTIVO', 0, 7)) === 0) {
                    $salida = $salida + $movimiento->monto;
                }
                if ((substr_compare($movimiento->cuenta->nombre, 'ZELLE', 0, 4)) === 0) {
                    $salida = $salida + $movimiento->monto;
                }
                if ((substr_compare($movimiento->cuenta->nombre, 'USDT', 0, 3)) === 0) {
                    $salida = $salida + $movimiento->monto;
                    $tasa = $movimiento->tasa;
                } else {
                    $tasa = $movimiento->tasa;
                    if ($movimiento->tasa != 0) {

                        $monto = ($movimiento->bs) / $movimiento->tasa;
                    } else {
                        $monto = '0';
                    }
                    $salida = $salida + $monto;
                }
                $bs = $bs -  $movimiento->bs;
            }

            
        }

        $saldo = $entrada - $salida;
        if ($cuentas) {
            $nombreCuenta = $cuentas->nombre; // Aquí obtienes el nombre de la cuenta
           
           
            if (($nombreCuenta==='EFECTIVO' or $nombreCuenta==='USDT' or $nombreCuenta==='ZELLE') ) {
                $saldo = $entrada - $salida;
             }else {
                
                if ($bs==0) {
                    
                   $saldo=0;
                   $tasa=0;
                }
                if ($MontoTasa!=0) {
                    $tasa=$EntradaBs/$MontoTasa;
                    $saldo = $bs/$tasa;
                }
             }

             
            
        } else {
            // Manejo de caso en que no se encuentra la cuenta con el ID dado
            $saldo = $entrada - $salida;
        }
         

            
        
        // $tasa = ($saldo===0) ? '0' : $bs/$saldo ;
        $MontoTotal = [
            'entrada' => $entrada,
            'salida' => $salida,
            'bs' => $bs,
            'saldo' => $saldo,
            'tasa' => $tasa,
        ];
        return $MontoTotal;
    }
}
