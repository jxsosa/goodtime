<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cuenta;
use App\Models\Movimiento;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;

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
    $cuentum=Cuenta::create($request->all());
    return redirect()->route('admin.cuentas.index', compact('cuentum'))->with('info', 'La cuenta se registro con éxito');
   }

    /**
     * Display the specified resource.
     */
    public function show(Cuenta $cuentum)
    {
        $movimientos= Movimiento::where('cuenta_id', '=', $cuentum->id)->get();
        return view('admin.cuentas.show', compact('cuentum', 'movimientos'));
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
   
    public function estado_cuenta($cuentum)
    {
        $cuenta= Cuenta::find($cuentum);
        $movimientos = $cuenta->movimientos()->orderBy('created_at', 'desc')->get(); // Supongamos que tienes una relación en el modelo Cliente
    
        $pdf = FacadePdf::loadView('admin.cuentas.estado_cuenta', compact('cuenta', 'movimientos'));
    
        // return $pdf->download('estado_cuenta.pdf');//descagar automatico
        return $pdf->stream('estado_cuenta.pdf');//muetra el pdf en la web
    }
    
}
