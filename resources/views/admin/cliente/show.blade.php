@extends('adminlte::page')
@section('title', 'GoodTime')

@section('content_header')
    <div class="">
        <h1>{{ $cliente->nombre }}</h1>
        <p>{{ $cliente->email }} TLF:
            {{ $cliente->telefono }}</p>
    </div>
    @php
        $entrada = 0;
        $salida = 0;
        $saldo = 0;
        $bs = 0;
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
@stop
@section('content')

    @if (session('info'))
        <div class="alert alert-success">
            <strong>{{ session('info') }}</strong>
        </div>
    @endif
    <div class="card">
        {{-- datatabla de movimiento --}}
        @livewire('cliente-movimiento-table', ['cliente' => $cliente])
    </div>
@stop
