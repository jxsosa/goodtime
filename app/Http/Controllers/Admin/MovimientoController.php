<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\Movimiento;
use Illuminate\Http\Request;

class MovimientoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$movimientos= Movimiento::paginate(20);
        $movimientos= Movimiento::all();
        
       
        return view('admin.movimientos.index', compact('movimientos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.movimientos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      //return request()->all();
      $request->validate([
       // 'nombre' => 'required|unique:cuentas'
    ]);
    $movimientos=Movimiento::create($request->all());
    return redirect()->route('admin.movimientos.edit', compact('movimientos'))->with('info', 'La movimientos se registro con éxito');
   }

    /**
     * Display the specified resource.
     */
    public function show(Movimiento $movimientos)
    {
        return view('admin.movimientos.show', compact('movimientos'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Movimiento $movimientos)
    {
        return view('admin.movimientos.edit', compact('movimientos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Movimiento $movimientos)
    {
        
        $request->validate([
            //'nombre' => "required|unique:cuentas,nombre,$cuentum->id"
        ]);

        $movimientos->update($request->all());
        return redirect()->route('admin.movimientos.edit', $movimientos)->with('info', 'El movimientos se actualizó con éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movimiento $movimientos)
    {
        $movimientos->delete();
        return redirect()->route('admin.movimientos.index')->with('info', 'movimientos  se elimino con éxito');
    }

    
}
