<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cambio;
use App\Models\Cliente;
use App\Models\Cuenta;
use App\Models\Movimiento;
use Illuminate\Http\Request;

use App\Http\Requests\ValidarMovimientoRequest;
use DragonCode\Support\Facades\Helpers\Arr;

class MovimientoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$movimientos= Movimiento::paginate(20);
        $movimientos = Movimiento::all();


        return view('admin.movimientos.index', compact('movimientos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        ///SE UTILIZA PLUCK PAR DARLE FORMATO DE ARRAY Y COLLETIVE LO ENTINEDA
        $cliente = Cliente::pluck('nombre', 'id')->sortBy('nombre');
        $cambio = Cambio::pluck('nombre', 'id');
        $cuenta = Cuenta::pluck('nombre', 'id');

        return view('admin.movimientos.create', compact('cliente', 'cambio', 'cuenta'));
    }

    public function efectivo()
    {
        ///SE UTILIZA PLUCK PAR DARLE FORMATO DE ARRAY Y COLLETIVE LO ENTINEDA
        $cliente = Cliente::pluck('nombre', 'id')->sortBy('nombre');
        $cambio = Cambio::pluck('nombre', 'id');
        $cuenta = Cuenta::pluck('nombre', 'id');
        $nombreBuscado = 'EFECTIVO';
        $idEncontrado=0;
        $cuentas2=Cuenta::all();
        //$resultado =array_column($cuenta2, 'nombre', 'id');
        $CuentaDefault = 0;
       
        // Buscar el id correspondiente al nombre buscado
        foreach ($cuentas2 as $cuenta2) {
            if ($cuenta2['nombre'] == $nombreBuscado) {
                $CuentaDefault = $cuenta2['id'];
                break; // Salir del bucle una vez encontrado
            }
        }

       //return    $idEncontrado;

        return view('admin.movimientos.efectivo', compact('cliente','cambio','cuenta', 'CuentaDefault'));
    }
    public function usdt()
    {
        ///SE UTILIZA PLUCK PAR DARLE FORMATO DE ARRAY Y COLLETIVE LO ENTINEDA
        $cliente = Cliente::pluck('nombre', 'id')->sortBy('nombre');
        $cambio = Cambio::pluck('nombre', 'id');
        $cuenta = Cuenta::pluck('nombre', 'id');
        $nombreBuscado = 'USDT';
        $idEncontrado=0;
        $cuentas2=Cuenta::all();
        //$resultado =array_column($cuenta2, 'nombre', 'id');
        $CuentaDefault = 0;
       
        // Buscar el id correspondiente al nombre buscado
        foreach ($cuentas2 as $cuenta2) {
            if ($cuenta2['nombre'] == $nombreBuscado) {
                $CuentaDefault = $cuenta2['id'];
                break; // Salir del bucle una vez encontrado
            }
        }

       //return    $idEncontrado;

        return view('admin.movimientos.usdt', compact('cliente','cambio','cuenta', 'CuentaDefault'));
    }

    public function zelle()
    {
        ///SE UTILIZA PLUCK PAR DARLE FORMATO DE ARRAY Y COLLETIVE LO ENTINEDA
        $cliente = Cliente::pluck('nombre', 'id')->sortBy('nombre');
        $cambio = Cambio::pluck('nombre', 'id');
        $cuenta = Cuenta::pluck('nombre', 'id');
        $nombreBuscado = 'ZELLE';
        $idEncontrado=0;
        $cuentas2=Cuenta::all();
        //$resultado =array_column($cuenta2, 'nombre', 'id');
        $CuentaDefault = 0;
       
        // Buscar el id correspondiente al nombre buscado
        foreach ($cuentas2 as $cuenta2) {
            if ($cuenta2['nombre'] == $nombreBuscado) {
                $CuentaDefault = $cuenta2['id'];
                break; // Salir del bucle una vez encontrado
            }
        }

       //return    $idEncontrado;

        return view('admin.movimientos.zelle', compact('cliente','cambio','cuenta', 'CuentaDefault'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ValidarMovimientoRequest $request)
    {
        $bs = $request->input('bs');
        $montoFormateado = (float) str_replace(',', '', $bs);
        $request->merge(['bs' => $montoFormateado]);

        $tasa = $request->input('tasa');
        $montoFormateado = (float) str_replace(',', '', $tasa);
        $request->merge(['tasa' => $montoFormateado]);

        $monto = $request->input('monto');
        $montoFormateado = (float) str_replace(',', '', $monto);
        $request->merge(['monto' => $montoFormateado]);
        
        $movimiento = Movimiento::create($request->all());
        return redirect()->route('admin.movimientos.index', compact('movimiento'))->with('info', 'La movimientos se registro con éxito');
        // return "la validaciones pasaron con exitos";
    }

    /**
     * Display the specified resource.
     */
    public function show(Movimiento $movimiento)
    {
        return view('admin.movimientos.show', compact('movimiento'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Movimiento $movimiento)
    {
        ///SE UTILIZA PLUCK PAR DARLE FORMATO DE ARRAY Y COLLETIVE LO ENTINEDA
        $cliente = Cliente::pluck('nombre', 'id')->sortBy('nombre');
        $cambio = Cambio::pluck('nombre', 'id');
        $cuenta = Cuenta::pluck('nombre', 'id');



        return view('admin.movimientos.edit', compact('cliente', 'cambio', 'cuenta', 'movimiento'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ValidarMovimientoRequest $request, Movimiento $movimiento)
    {

        $bs = $request->input('bs');
        $montoFormateado = (float) str_replace(',', '', $bs);
        $request->merge(['bs' => $montoFormateado]);

        $tasa = $request->input('tasa');
        $montoFormateado = (float) str_replace(',', '', $tasa);
        $request->merge(['tasa' => $montoFormateado]);

        $monto = $request->input('monto');
        $montoFormateado = (float) str_replace(',', '', $monto);
        $request->merge(['monto' => $montoFormateado]);

        $movimiento->update($request->all());
        return redirect()->route('admin.movimientos.edit', $movimiento)->with('info', 'El movimientos se actualizó con éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movimiento $movimiento)
    {
        $movimiento->delete();
        return redirect()->route('admin.movimientos.index')->with('info', 'movimientos  se elimino con éxito');
    }
}
