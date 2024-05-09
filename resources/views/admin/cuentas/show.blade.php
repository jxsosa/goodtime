@extends('adminlte::page')
@section('title', 'GoodTime')

@section('content_header')
    <h1>Mostrar detalle de las cuenta: {{ $cuentum->nombre }}</h1>
    @php
        $entrada = 0;
        $salida = 0;
        $saldo = 0;
        $bs = 0;
        //$cuentas=Cuenta::find($cuentum->id);
    @endphp

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

        {{-- <div class="col-sm-3">
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
        </div> --}}
        @if ($cuentum->nombre === 'EFECTIVO')
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
                            {{ $tasa = $saldo == 0 ? '0' : number_format($bs / $saldo, 2, '.', ',') }}</span>
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
