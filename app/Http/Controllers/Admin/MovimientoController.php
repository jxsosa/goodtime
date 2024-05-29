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
        $cliente = Cliente::orderBy('nombre')->pluck('nombre', 'id');;
        $cambio = Cambio::orderBy('nombre')->pluck('nombre', 'id');
        $cuenta = Cuenta::orderBy('nombre')->pluck('nombre', 'id');

        return view('admin.movimientos.create', compact('cliente', 'cambio', 'cuenta'));
    }

    public function efectivo()
    {
        ///SE UTILIZA PLUCK PAR DARLE FORMATO DE ARRAY Y COLLETIVE LO ENTINEDA
        $cliente = Cliente::orderBy('nombre')->pluck('nombre', 'id');
        $cambio = Cambio::orderBy('nombre')->pluck('nombre', 'id');
        $cuenta = Cuenta::orderBy('nombre')->pluck('nombre', 'id');
        $nombreBuscado = 'EFECTIVO';
        $idEncontrado = 0;
        $cuentas2 = Cuenta::all();
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

        return view('admin.movimientos.efectivo', compact('cliente', 'cambio', 'cuenta', 'CuentaDefault'));
    }
    public function usdt()
    {
        ///SE UTILIZA PLUCK PAR DARLE FORMATO DE ARRAY Y COLLETIVE LO ENTINEDA
        $cliente = Cliente::orderBy('nombre')->pluck('nombre', 'id');
        $cambio = Cambio::orderBy('nombre')->pluck('nombre', 'id');
        $cuenta = Cuenta::orderBy('nombre')->pluck('nombre', 'id');
        $nombreBuscado = 'USDT';
        $idEncontrado = 0;
        $cuentas2 = Cuenta::all();
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

        return view('admin.movimientos.usdt', compact('cliente', 'cambio', 'cuenta', 'CuentaDefault'));
    }

    public function zelle()
    {
        ///SE UTILIZA PLUCK PAR DARLE FORMATO DE ARRAY Y COLLETIVE LO ENTINEDA
        $cliente = Cliente::orderBy('nombre')->pluck('nombre', 'id');
        $cambio = Cambio::orderBy('nombre')->pluck('nombre', 'id');
        $cuenta = Cuenta::orderBy('nombre')->pluck('nombre', 'id');
        $nombreBuscado = 'ZELLE';
        $idEncontrado = 0;
        $cuentas2 = Cuenta::all();
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

        return view('admin.movimientos.zelle', compact('cliente', 'cambio', 'cuenta', 'CuentaDefault'));
    }
    public function ganancias()
    {
        ///SE UTILIZA PLUCK PAR DARLE FORMATO DE ARRAY Y COLLETIVE LO ENTINEDA
        $cliente = Cliente::orderBy('nombre')->pluck('nombre', 'id');
        $cambio = Cambio::orderBy('nombre')->pluck('nombre', 'id');
        $cuenta = Cuenta::orderBy('nombre')->orderBy('nombre')->pluck('nombre', 'id');
        $nombreBuscado = 'GANANCIAS';
        $idEncontrado = 0;
        $cuentas2 = Cuenta::all();
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

        return view('admin.movimientos.ganancias', compact('cliente', 'cambio', 'cuenta', 'CuentaDefault'));
    }
    public function transferir()
    {
        ///SE UTILIZA PLUCK PAR DARLE FORMATO DE ARRAY Y COLLETIVE LO ENTINEDA
        //$cliente = Cliente::pluck('nombre', 'id')->sortBy('nombre');
        //$cambio = Cambio::pluck('nombre', 'id');
        $cliente = Cliente::orderBy('nombre')->pluck('nombre', 'id');
        $nombreBuscado = 'ZELLE';
        $idEncontrado = 0;
        $cuentas2 = Cuenta::all();
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

        return view('admin.movimientos.transferir', compact('cuenta', 'CuentaDefault'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(ValidarMovimientoRequest $request)
    {
        $bs = $request->input('bs');
        $montoFormateado = (float) str_replace(',', '', $bs);
        $bs = $montoFormateado;
        $request->merge(['bs' => $montoFormateado]);

        $tasa = $request->input('tasa');
        $montoFormateado = (float) str_replace(',', '', $tasa);
        $tasa = $montoFormateado;
        $request->merge(['tasa' => $montoFormateado]);

        $monto = $request->input('monto');
        $montoFormateado = (float) str_replace(',', '', $monto);
        $monto = $montoFormateado;
        $request->merge(['monto' => $montoFormateado]);

        $CuentaOrigen = $request->input('cuenta_id');
        $CuentaDestino = $request->input('cuenta_id2');
        $TipoOrigen = 'salida';
        $TipoDesino = 'entrada';
        $ref = $request->input('ref');
        $descripcion = $request->input('descripcion');
        $cambio = $request->input('cambio_id');
        $FechaEntrega = null;
        $user = $request->input('user_id');
        $cliente = 6;
        $request->merge(['monto' => $montoFormateado]);

        if ($request->has('cuenta_id2')) {
            // La variable 'mi_variable' se envió desde el formulario
            // Realiza la tarea específica aquí

            $datos = [
                [
                    'bs' => $bs,
                    'tasa' => $tasa,
                    'monto' => $monto,
                    'ref' => $ref,
                    'descripcion' => $descripcion,
                    'tipo' => $TipoOrigen,
                    'fecha_entrega' => $FechaEntrega,
                    'user_id' => $user,
                    'cambio_id' => '1',
                    'cliente_id' => $cliente,
                    'cuenta_id' => $CuentaOrigen    
                ],
                [
                    'bs' => $bs,
                    'tasa' => $tasa,
                    'monto' => $monto,
                    'ref' => $ref,
                    'descripcion' => $descripcion,
                    'tipo' => $TipoDesino,
                    'fecha_entrega' => $FechaEntrega,
                    'user_id' => $user,
                    'cambio_id' => '1',
                    'cliente_id' => $cliente,
                    'cuenta_id' => $CuentaDestino
                ],
                // Agrega más registros según tus necesidades
            ];
            
            foreach ($datos as $registro) {
                $movimiento =Movimiento::create($registro);
            }
            
        } else {
            // La variable no se envió
            // Realiza otra tarea o muestra un mensaje de error
            $movimiento = Movimiento::create($request->all());
        }
       
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
        $cliente = Cliente::orderBy('nombre')->pluck('nombre', 'id');
        $cambio = Cambio::orderBy('nombre')->pluck('nombre', 'id');
        $cuenta = Cuenta::orderBy('nombre')->pluck('nombre', 'id');



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
