@extends('adminlte::page')
@section('title', 'Clientes')

@section('content_header')

    <a class="btn btn-secondary float-right " href="{{ route('admin.cliente.create') }}">Agregar cliente</a>
    <h1>Lista de Clientes</h1>
@stop
@section('content')

    @if (session('info'))
        <div class="alert alert-success">
            <strong>{{ session('info') }}</strong>
        </div>
    @endif
    <?php
    use App\Models\Movimiento;
    use App\Models\Cliente;
    $entrada = 0;
    $salida = 0;
    $saldo = 0;
    $bs=0; 
    $nombreBuscado = 'GASTOS';
    $idEncontrado=0;
    $clientes=Cliente::all();
     
        
       
        // Buscar el id correspondiente al nombre buscado
        foreach ($clientes as $cliente) {
            if ($cliente['nombre'] == $nombreBuscado) {
                $idEncontrado = $cliente['id'];
                break; // Salir del bucle una vez encontrado
            }
        }
    //$movimientos=Movimiento::all();
    $movimientos = Movimiento::where('cliente_id', '<>', $idEncontrado)->get();
    ?>
   

    @foreach ($movimientos as $movimiento)
        @if ($movimiento->tipo == 'entrada')
            @php
                $entrada = $entrada + $movimiento->monto;
                $bs = $bs + $movimiento->bs;

            @endphp
        @endif
        @if ($movimiento->tipo == 'salida')
            @php
                $salida = $salida + $movimiento->monto;
                $bs = $bs - $movimiento->bs;

            @endphp
        @endif
    @endforeach
    @php
        $saldo = $entrada - $salida;
    @endphp

    <div class="row ">
        <div class="col-sm-3">
            <div class="info-box bg-gradient-warning">
                <span class="info-box-icon"><i class="fas fa-money-bill-wave-alt"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">SALDO BS TOTAL</span>
                    <span class="info-box-number">Bs {{ number_format($bs, 2, '.', ',') }}</span>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="info-box bg-info">
                <span class="info-box-icon"><i class="fas fa-plus-circle"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">SALDO ENTRADA</span>
                    <span class="info-box-number ">$ {{ number_format($entrada, 2, '.', ',') }}</span>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="info-box bg-danger">
                <span class="info-box-icon"><i class="fas fa-minus-circle"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">SALDO SALIDA</span>
                    <span class="info-box-number">$ {{ number_format($salida, 2, '.', ',') }}</span>
                </div>
            </div>
        </div>

        <div class="col-sm-3">
            <div class="info-box bg-success">
                <span class="info-box-icon"><i class="fas fa-dollar-sign"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">SALDO TOTAL</span>
                    <span class="info-box-number">$ {{ number_format($saldo, 2, '.', ',') }}</span>
                </div>
            </div>
        </div>


    </div>
    <div class="card">

        
        <div class="card-body">@livewire('cliente-table')</div>

    </div>
    {{-- para agregarle estilo a la alertas com sweetalert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Livewire.On('Atencion', function(message) {
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: message,
                showConfirmButton: false,
                timer: 1500
            });
        })

        Livewire.On('error', function(message) {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: message,
                // footer: '<a href="#">Why do I have this issue?</a>'
            });
        })
    </script>
@stop
@section('js')

@stop
