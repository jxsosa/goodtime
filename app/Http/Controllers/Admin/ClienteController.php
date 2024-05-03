<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ValidarDatosCliente;
use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Movimiento;
use Illuminate\Support\Facades\Redirect;
use PhpParser\Node\Stmt\Return_;
use App\Http\Requests\ValidaDatosCliente;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = Cliente::all();
        return view('admin.cliente.index', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.cliente.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $request->validate([
        'nombre' => 'required',
        'telefono' => 'required|regex:/^[0-9]{11}$/'
       ]);
       
       //return $request->all(); //retorna el array enviado
     $cliente = Cliente::create($request->all());
      //return $cliente;
      return redirect()->route('admin.cliente.edit', $cliente)->with('info', 'El cliente se creo con exito');
     }

    /**
     * Display the specified resource.
     */
    public function show(Cliente $cliente )
    {
       
         $movimientos= Movimiento::where('cliente_id', '=', $cliente->id)->get();
                                           
         //var_dump($movimientos) ;                                  
    
           
        return view('admin.cliente.show', compact('cliente', 'movimientos'));
       //return $movimientos;
    }
/////OJOJ para mejorar tengo que ver como llamarlo desde la vista
    // public function montoCliente($id){
    //     $entrada = 0;
    //     $salida = 0;
    //     $saldo = 0;
    //     $bs=0;
    //     $movimientos=Movimiento::where('cliente_id', '=', $id)->get();

    //     foreach ($movimientos as $movimiento) {
    //         if ($movimiento->tipo == 'entrada') {
    //             $entrada = $entrada + $movimiento->monto;
    //             $bs = $bs + $movimiento->bs;
    //         }
    //         if ($movimiento->tipo == 'salida') {
    //             $salida = $salida + $movimiento->monto;
    //              $bs = $bs - $movimiento->bs;
    //         }
    //     }
    //     $saldo = $entrada - $salida;
    //     return $saldo;
    // }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cliente $cliente)
    {
        return view('admin.cliente.edit', compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cliente $cliente)
    {
        $request->validate([
            'nombre' => 'required',
            'telefono' => 'required'
           ]);
        $cliente->update($request->all());
        
        return redirect()->route('admin.cliente.edit', $cliente)->with('info', 'El cliente se actualizo con exito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        return redirect()->route('admin.cliente.index')->with('info', 'El cliente se elimino con exito');


    }
}
