<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cuenta;
use Illuminate\Http\Request;

class CuentaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cuentas= Cuenta::all();
        return view('admin.cuentas.index', compact('cuentas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.cuentas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      //return request()->all();
      $request->validate([
        'nombre' => 'required|unique:cuentas'
    ]);
    $cuenta=Cuenta::create($request->all());
    return redirect()->route('admin.cuentas.edit', compact('cuenta'))->with('info', 'La cuenta se registro con éxito');
   }

    /**
     * Display the specified resource.
     */
    public function show(Cuenta $cuenta)
    {
        return view('admin.cuentas.show', compact('cuenta'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cuenta $cuentum)
    {
        return view('admin.cuentas.edit', compact('cuentum'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cuenta $cuentum)
    {
        
        $request->validate([
            'nombre' => "required|unique:cuentas,nombre,$cuentum->id"
        ]);

        $cuentum->update($request->all());
        return redirect()->route('admin.cuentas.edit', $cuentum)->with('info', 'La cuenta se actualizó con éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cuenta $cuentum)
    {
        $cuentum->delete();
        return redirect()->route('admin.cuentas.index')->with('info', 'La cuenta se elimino con éxito');
    }
}
