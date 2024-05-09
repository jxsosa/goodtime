<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cambio;
use App\Models\Movimiento;
use Illuminate\Http\Request;

class CambioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $cambios= Cambio::all();
        return view('admin.cambios.index', compact('cambios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.cambios.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //return request()->all();
        $request->validate([
            'nombre' => 'required|unique:cambios'
        ]);
        $cambio=Cambio::create($request->all());
        return redirect()->route('admin.cambios.index', compact('cambio'))->with('info', 'El cambio se registro con éxito');
       
    }

    /**
     * Display the specified resource.
     */
    public function show(Cambio $cambio)
    {
        $movimientos= Movimiento::where('cambio_id', '=', $cambio->id)->get();
        return view('admin.cambios.show', compact('cambio', 'movimientos'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cambio $cambio)
    {
        return view('admin.cambios.edit', compact('cambio'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cambio $cambio)
    {
        $request->validate([
            'nombre' => "required|unique:cambios,nombre,$cambio->id"
        ]);

        $cambio->update($request->all());
        return redirect()->route('admin.cambios.edit', $cambio)->with('info', 'El cambio se actualizó con éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cambio $cambio)
    {
        $cambio->delete();
        return redirect()->route('admin.cambios.index')->with('info', 'El cambio se elimino con éxito');
    }
}
