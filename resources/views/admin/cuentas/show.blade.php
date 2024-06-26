@extends('adminlte::page')
@section('title', 'GoodTime')

@section('content_header')
    <h1>Mostrar detalle de las cuenta: {{ $cuentum->nombre }} <a href="{{ route('admin.cuenta.estado_cuenta', ['cuentum' => $cuentum->id]) }}" target="_blank" class="btn btn-outline-danger">
        <i class="glyphicon glyphicon-file"></i> Estado de Cuenta PDF
    </a></h1>
    @php
        $entrada = 0;
        $salida = 0;
        $saldo = 0;
        $tasa=0;
        $bs = 0;
        $MontoTasa=0;
        $EntradaBs=0;
        //$cuentas=Cuenta::find($cuentum->id);
    @endphp

    @foreach ($movimientos as $movimiento)
        @if ($movimiento->tipo == 'entrada')
            @php
                $entrada = $entrada + $movimiento->monto;
                $bs = $bs + $movimiento->bs;
                //$tasa =$tasa+  $movimiento->tasa;
                $EntradaBs = $EntradaBs + $movimiento->bs;
                
                if ($movimiento->bs != 0 and $movimiento->tasa != 0) {
                    $MontoTasa=$MontoTasa+($movimiento->bs/$movimiento->tasa);
                    }
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
        if ($MontoTasa!=0) {
            $tasa=$EntradaBs/$MontoTasa;
        }
        
        
        $saldo = $entrada - $salida;
    @endphp

    <div class="row ">

       
        @if ($cuentum->nombre === 'EFECTIVO' or $cuentum->nombre === 'ZELLE'or $cuentum->nombre === 'USDT')
            <div class="col-sm-3">
                <div class="info-box bg-success">
                    <span class="info-box-icon"><i class="fas fa-dollar-sign"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">SALDO TOTAL</span>
                        <span class="info-box-number">$ {{ number_format($saldo, 2, '.', ',') }}</span>
                    </div>
                </div>
            </div>
        @else
            <div class="col-sm-3">
                <div class="info-box bg-secondary">
                    <span class="info-box-icon"><i class="fas fa-hand-holding-usd"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">TASA</span>
                        <span class="info-box-number">
                            {{ $tasa = $saldo == 0 ? '0' : number_format($tasa, 2, '.', ',') }}</span>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="info-box bg-success">
                    <span class="info-box-icon"><i class="fas fa-dollar-sign"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">SALDO TOTAL</span>
                        <span class="info-box-number">$
                            {{ $retVal = $tasa == 0 ? '0' : number_format($bs /$tasa, 2, '.', ',') }}</span>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="info-box bg-gradient-warning">
                    <span class="info-box-icon"><i class="fas fa-money-bill-wave-alt"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">SALDO BS TOTAL</span>
                        <span class="info-box-number">Bs {{ number_format($bs, 2, '.', ',') }}</span>
                    </div>
                </div>
            </div>


    </div>
    @endif





@stop

@section('content')
    @if (session('info'))
        <div class="alert alert-success">
            <strong>{{ session('info') }}</strong>
        </div>
    @endif
    <div class="card">
        {{-- datatabla de movimiento --}}
        @livewire('cuenta-movimiento-table', ['cuentum' => $cuentum])
    </div>
@stop
