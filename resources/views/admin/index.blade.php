@extends('adminlte::page')
@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    @php
        use App\Models\Movimiento;
        use App\Models\Cuenta;
        use App\Models\Cliente;
        $entrada = 0;
        $salida = 0;
        $saldo = 0;
        $bs = 0;
        $usdt = 0;
        $efectivo = 0;
        $banco = null;
        $banesco = 0;
        $TasaBanesco = 0;
        $venezuela = 0;
        $TasaVenezuela = 0;
        $mercantil = 0;
        $TasaMercantil = 0;
        $provincial = 0;
        $TasaProvincial = 0;
        $banplus = 0;
        $TasaBanplus = 0;
        $BanescoMonto = 0;
        $VenezuelaMonto = 0;
        $MercantilMonto = 0;
        $ProvincialMonto = 0;
        $BanplusMonto = 0;
        $MontoTasa = 0;
        $EntradaBs = 0;
        $MontoTasaBanplus = 0;
        $ganancias = 0;
        $MontoTasaProvincial = 0;
        $MontoTasaMercantil = 0;
        $MontoTasaVenezuela = 0;
        $MontoTasaBanesco = 0;
        $tasaBanplus = 0;
        $tasaProvincial = 0;
        $tasaMercantil = 0;
        $tasaVenezuela = 0;
        $tasaBanesco = 0;
        $BanescoBsIn = 0;
        $VenezuelaBsIn = 0;
        $MercantilBsIn = 0;
        $ProvincialBsIn = 0;
        $BanplusBsIn = 0;
        $BanescoBsOut=0;
        $VenezuelaBsOut = 0;
        $MercantilBsOut = 0;
        $ProvincialBsOut = 0;
        $BanplusBsOut = 0;
        $MontoTasaBanescoOut=0;
        $MontoTasaVenezuelaOut=0;
        $MontoTasaMercantilOut=0;
        $MontoTasaProvincialOut=0;
        $MontoTasaBanplusOut=0;
        $tasaBanescoOut=0;
        $tasaVenezuelaOut=0;
        $tasaMercantilOut=0;
        $tasaProvincialOut=0;
        $tasaBanplusOut=0;
        $EfectivoIn = 0;
        $USDTIn = 0;
        $EfectivoOut = 0;
        $USDTOut = 0;
        $zelle = 0;
        $zelleIn = 0;
        $zelleOut = 0;
        $gasto = 0;
        
        $nombreBuscado = 'GASTOS';
        $idEncontrado = 0;
        $clientes = Cliente::all();

        // Buscar el id correspondiente al nombre buscado
        foreach ($clientes as $cliente) {
            if ($cliente['nombre'] == $nombreBuscado) {
                $idEncontrado = $cliente['id'];
                break; // Salir del bucle una vez encontrado
            }
        }
        $movimientos = Movimiento::all();
        //$movimientos = Movimiento::where('cliente_id', '<>', $idEncontrado)->get();
    @endphp

    @foreach ($movimientos as $movimiento)
        @if ($movimiento->tipo == 'entrada')
            @php
                $entrada = $entrada + $movimiento->monto;
                if (str_contains($movimiento->cliente->nombre, 'GASTOS')) {
                    // $gasto = $gasto + $movimiento->monto;
                }

                if (substr_compare($movimiento->cuenta->nombre, 'EFECTIVO', 0, 7) == 0) {
                    $efectivo = $efectivo + $movimiento->monto;
                    $EfectivoIn = $EfectivoIn + $movimiento->monto;
                }
                if (substr_compare($movimiento->cuenta->nombre, 'USDT', 0, 3) == 0) {
                    $usdt = $usdt + $movimiento->monto;
                    //$USDTIn = $USDTIn + $movimiento->monto;
                }
                if (substr_compare($movimiento->cuenta->nombre, 'ZELLE', 0, 4) == 0) {
                    $zelle = $zelle + $movimiento->monto;
                    $zelleIn = $zelleIn + $movimiento->monto;
                }
                if (str_contains($movimiento->cliente->nombre, 'USDT')) {
                    //$usdt = $usdt + $movimiento->monto;

                    $USDTIn = $USDTIn + $movimiento->monto;
                }

                if (substr_compare($movimiento->cuenta->nombre, 'BANESCO', 0, 5) == 0) {
                    $BanescoMonto = $BanescoMonto + $movimiento->monto;
                    $banesco = $banesco + $movimiento->bs;
                    $BanescoBsIn = $BanescoBsIn + $movimiento->bs;
                    // echo $banesco."-";
                    $bs = $bs + $movimiento->bs;

                    if ($movimiento->bs != 0 and $movimiento->tasa != 0) {
                        $MontoTasaBanesco = $MontoTasaBanesco + $movimiento->bs / $movimiento->tasa;
                    }
                   $tasaBanesco = $BanescoBsIn / $MontoTasaBanesco;
                    //echo "-". $tasaBanesco ."-";
                }
                if (substr_compare($movimiento->cuenta->nombre, 'VENEZUELA', 0, 8) == 0) {
                    $VenezuelaMonto = $VenezuelaMonto + $movimiento->monto;
                    $venezuela = $venezuela + $movimiento->bs;
                    $VenezuelaBsIn = $VenezuelaBsIn + $movimiento->bs;
                    $bs = $bs + $movimiento->bs;
                    if ($movimiento->bs != 0 and $movimiento->tasa != 0) {
                        $MontoTasaVenezuela = $MontoTasaVenezuela + $movimiento->bs / $movimiento->tasa;
                    }
                    $tasaVenezuela = $VenezuelaBsIn / $MontoTasaVenezuela;
                }
                if (substr_compare($movimiento->cuenta->nombre, 'MERCANTIL', 0, 8) == 0) {
                    $MercantilMonto = $MercantilMonto + $movimiento->monto;
                    $mercantil = $mercantil + $movimiento->bs;
                    $MercantilBsIn = $MercantilBsIn + $movimiento->bs;
                    $bs = $bs + $movimiento->bs;
                    if ($movimiento->bs != 0 and $movimiento->tasa != 0) {
                        $MontoTasaMercantil = $MontoTasaMercantil + $movimiento->bs / $movimiento->tasa;
                    }
                    $tasaMercantil = $MercantilBsIn / $MontoTasaMercantil;
                }
                if (substr_compare($movimiento->cuenta->nombre, 'PROVINCIAL', 0, 9) == 0) {
                    $ProvincialMonto = $ProvincialMonto + $movimiento->monto;
                    $provincial = $provincial + $movimiento->bs;
                    $ProvincialBsIn = $ProvincialBsIn + $movimiento->bs;
                    $bs = $bs + $movimiento->bs;
                    if ($movimiento->bs != 0 and $movimiento->tasa != 0) {
                        $MontoTasaProvincial = $MontoTasaProvincial + $movimiento->bs / $movimiento->tasa;
                    }
                    $tasaProvincial = $ProvincialBsIn / $MontoTasaProvincial;
                }
                if (substr_compare($movimiento->cuenta->nombre, 'BANPLUS', 0, 6) == 0) {
                    $BanplusMonto = $BanplusMonto + $movimiento->monto;
                    $banplus = $banplus + $movimiento->bs;
                    $BanplusBsIn = $BanplusBsIn + $movimiento->bs;
                    $bs = $bs + $movimiento->bs;
                    if ($movimiento->bs != 0 or $movimiento->tasa != 0) {
                        $MontoTasaBanplus = $MontoTasaBanplus + $movimiento->bs / $movimiento->tasa;
                    }
                    $tasaBanplus = $BanplusBsIn / $MontoTasaBanplus;
                }

            @endphp
        @endif
        @php

        @endphp
        @if ($movimiento->tipo == 'salida')
            @php
                $salida = $salida + $movimiento->monto;
                if (str_contains($movimiento->cliente->nombre, 'GASTOS')) {
                    $gasto = $gasto + $movimiento->monto;
                }

                if (substr_compare($movimiento->cuenta->nombre, 'EFECTIVO', 0, 7) == 0) {
                    $efectivo = $efectivo - $movimiento->monto;
                    $EfectivoOut = $EfectivoOut + $movimiento->monto;
                }
                if (substr_compare($movimiento->cuenta->nombre, 'USDT', 0, 3) == 0) {
                    $usdt = $usdt - $movimiento->monto;
                    //$USDTOut = $USDTOut + $movimiento->monto;
                }
                if (substr_compare($movimiento->cuenta->nombre, 'ZELLE', 0, 4) == 0) {
                    $zelle = $zelle - $movimiento->monto;
                    $zelleOut = $zelleOut + $movimiento->monto;
                }
                if (str_contains($movimiento->cliente->nombre, 'USDT')) {
                    //$usdt = $usdt - $movimiento->monto;
                    $USDTOut = $USDTOut + $movimiento->monto;
                }

                if (substr_compare($movimiento->cuenta->nombre, 'BANESCO', 0, 5) == 0) {
                    $BanescoMonto = $BanescoMonto - $movimiento->monto;
                    $banesco = $banesco - $movimiento->bs;
                    $bs = $bs - $movimiento->bs;
                    $BanescoBsOut = $BanescoBsOut + $movimiento->bs;
                    if ($movimiento->bs != 0 and $movimiento->tasa != 0) {
                        $MontoTasaBanescoOut = $MontoTasaBanescoOut + $movimiento->bs / $movimiento->tasa;
                    }
                    $tasaBanescoOut = $BanescoBsOut / $MontoTasaBanescoOut;
                }
                if (substr_compare($movimiento->cuenta->nombre, 'VENEZUELA', 0, 8) == 0) {
                    $VenezuelaMonto = $VenezuelaMonto - $movimiento->monto;
                    $venezuela = $venezuela - $movimiento->bs;
                    $bs = $bs - $movimiento->bs;
                    $VenezuelaBsOut = $VenezuelaBsOut + $movimiento->bs;
                    if ($movimiento->bs != 0 and $movimiento->tasa != 0) {
                        $MontoTasaVenezuelaOut = $MontoTasaVenezuelaOut + $movimiento->bs / $movimiento->tasa;
                    }
                    $tasaVenezuelaOut = $VenezuelaBsOut / $MontoTasaVenezuelaOut;
                }
                if (substr_compare($movimiento->cuenta->nombre, 'MERCANTIL', 0, 8) == 0) {
                    $MercantilMonto = $MercantilMonto - $movimiento->monto;
                    $mercantil = $mercantil - $movimiento->bs;
                    $bs = $bs - $movimiento->bs;
                    $MercantilBsOut = $MercantilBsOut + $movimiento->bs;
                    if ($movimiento->bs != 0 and $movimiento->tasa != 0) {
                        $MontoTasaMercantilOut = $MontoTasaMercantilOut + $movimiento->bs / $movimiento->tasa;
                    }
                    $tasaMercantilOut = $MercantilBsOut / $MontoTasaMercantilOut;
                }
                if (substr_compare($movimiento->cuenta->nombre, 'PROVINCIAL', 0, 9) == 0) {
                    $ProvincialMonto = $ProvincialMonto - $movimiento->monto;
                    $provincial = $provincial - $movimiento->bs;
                    $bs = $bs - $movimiento->bs;
                    $ProvincialBsOut = $ProvincialBsOut + $movimiento->bs;
                    if ($movimiento->bs != 0 and $movimiento->tasa != 0) {
                        $MontoTasaProvincialOut = $MontoTasaProvincialOut + $movimiento->bs / $movimiento->tasa;
                    }
                    $tasaProvincialOut = $ProvincialBsOut / $MontoTasaProvincialOut;
                }
                if (substr_compare($movimiento->cuenta->nombre, 'BANPLUS', 0, 6) == 0) {
                    $BanplusMonto = $BanplusMonto - $movimiento->monto;
                    $banplus = $banplus - $movimiento->bs;
                    $bs = $bs - $movimiento->bs;
                    $BanplusBsOut = $BanplusBsOut + $movimiento->bs;
                    if ($movimiento->bs != 0 and $movimiento->tasa != 0) {
                        $MontoTasaBanplusOut = $MontoTasaBanplusOut + $movimiento->bs / $movimiento->tasa;
                    }
                    $tasaBanplusOut = $BanplusBsOut / $MontoTasaBanplusOut;
                }

            @endphp
        @endif
    @endforeach
    @php

        $saldo = $entrada - $salida;

        // $tasaBanesco=($tasaBanesco+ $tasaBanescoOut)/2;
        // $tasaVenezuela=($tasaVenezuela+ $tasaVenezuelaOut)/2;
        // $tasaMercantil=($tasaMercantil+ $tasaMercantilOut)/2;
        // $tasaProvincial=($tasaProvincial+ $tasaProvincialOut)/2;
        // $tasaBanplus=($tasaBanplus+ $tasaBanplusOut)/2;        
        if ($tasaBanesco == 0) {
            $BanescoCobra = 0;
        } else {
            $BanescoCobra = $banesco / $tasaBanesco;
        }
        if ($tasaVenezuela == 0) {
            $VenezuelaCobra = 0;
        } else {
            $VenezuelaCobra = $venezuela / $tasaVenezuela;
        }
        if ($tasaMercantil == 0) {
            $MercantilCobra = 0;
        } else {
            $MercantilCobra = $mercantil / $tasaMercantil;
        }
        if ($tasaProvincial == 0) {
            $ProvincialCobra = 0;
        } else {
            $ProvincialCobra = $provincial / $tasaProvincial;
        }
        if ($tasaBanplus == 0) {
            $BanplusCobra = 0;
        } else {
            $BanplusCobra = $banplus / $tasaBanplus;
        }
        $CuentaPagar = 0;
        $CuentaCobrar = 0;
        $CuentaUsdt=0;
        $CuentaUsdt=$USDTOut-$USDTIn;

        //$CuentaCobrar=($EfectivoIn-$EfectivoOut) + ($USDTIn-$USDTOut) + $BanplusCobra+$ProvincialCobra+$MercantilCobra+$VenezuelaCobra+ $BanescoCobra;
        //$CuentaPagar=$EfectivoOut + $USDTOut+$BanplusMonto + $ProvincialMonto + $MercantilMonto + $VenezuelaMonto + $BanescoMonto;
        $CuentaPagar = $saldo + $gasto;

        $MontoDolaresBs = $BanplusCobra + $ProvincialCobra + $MercantilCobra + $VenezuelaCobra + $BanescoCobra;
        $CuentaCobrar = $efectivo + $zelle + $usdt+ $MontoDolaresBs;
        $ganancias = $CuentaCobrar - $CuentaPagar;

    @endphp

    <div class="container ">
        <div class="row">
            <div class="col-sm-4">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>$ {{ number_format($ganancias, 2, '.', ',') }}</h3>
                        {{-- <p>SALDO TOTAL {{ number_format($saldo, 2, '.', ',') }}</p> --}}
                        <p>SALDO TOTAL</p>

                    </div>
                    <div class="icon">

                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <a href="#" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="small-box bg-secondary">
                    <div class="inner">
                        <h3>$ {{ number_format($CuentaCobrar, 2, '.', ',') }}</h3>
                        {{-- <p>SALDO TOTAL {{ number_format($ganacias, 2, '.', ',') }}</p> --}}
                        <p>CUENTA POR COBRAR SALDO </p>

                    </div>
                    <div class="icon">

                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <a href="{{ url('./admin/cuenta') }}" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="small-box bg-gradient-danger">
                    <div class="inner">
                        <h3>$ {{ number_format($CuentaPagar, 2, '.', ',') }}</h3>
                        <p> CUENTA POR PAGAR SALDO</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-dollar-sign "></i>
                    </div> <a href="{{ url('./admin/cliente') }}" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                        </a>
                </div>
            </div>
        </div>
        <div class="row">

            <div class="col-sm-3">
                <div class="small-box bg-gradient-primary">
                    <div class="inner">
                        <h3>Bs {{ number_format($bs, 2, '.', ',') }}</h3>
                        <p>TOTAL $:{{ number_format($MontoDolaresBs, 2, '.', ',') }}/TASA:{{$retVal = ($MontoDolaresBs==0) ? '0' : number_format($bs/$MontoDolaresBs, 2, '.', ',') ;  }} </p>
                        <p></p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-coins"></i>
                    </div>
                    <a href="#" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="small-box bg-gradient-Light">
                    <div class="inner">
                        <h3>$ {{ number_format($efectivo, 2, '.', ',') }}</h3>
                        <p>TOTAL EFECTIVO</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-hand-holding-usd"></i>
                    </div>
                    <a href="{{ url('./admin/cuenta/1') }}" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="small-box bg-gradient-warning">
                    <div class="inner">
                        <h3>$ {{ number_format($usdt+$CuentaUsdt, 2, '.', ',') }}</h3>
                        <p>USDT</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-comment-dollar"></i>
                    </div>
                    <a href="#" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="small-box bg-gradient-info">
                    <div class="inner">
                        <h3>$ {{ number_format($zelle, 2, '.', ',') }}</h3>
                        <p>ZELLE</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-comment-dollar"></i>
                    </div>
                    <a href="#" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm">
                <div class="small-box bg-gradient-dark">
                    <div class="inner">
                        <h3>Bs {{ number_format($venezuela, 2, '.', ',') }}</h3>
                        <p>TASA {{ number_format($tasaVenezuela, 2, '.', ',') }}</p>
                        <p>BANCO VENEZUELA</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <a href="#" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-sm">
                <div class="small-box bg-gradient-dark">
                    <div class="inner">
                        <h3>Bs {{ number_format($banesco, 2, '.', ',') }}</h3>
                        <p>TASA {{ number_format($tasaBanesco, 2, '.', ',') }}</p>
                        <p>BANCO BANESCO </p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <a href="#" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-sm">
                <div class="small-box bg-gradient-dark">
                    <div class="inner">
                        <h3>Bs {{ number_format($provincial, 2, '.', ',') }}</h3>
                        <p>TASA {{ number_format($tasaProvincial, 2, '.', ',') }}</p>

                        <p>BANCO PROVINCIAL</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <a href="#" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-sm">
                <div class="small-box bg-gradient-dark">
                    <div class="inner">
                        <h3>Bs {{ number_format($mercantil, 2, '.', ',') }}</h3>
                        <p>TASA {{ number_format($tasaMercantil, 2, '.', ',') }}</p>
                        <p>BANCO MERCANTIL</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <a href="#" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-sm">
                <div class="small-box bg-gradient-dark">
                    <div class="inner">
                        <h3>Bs {{ number_format($banplus, 2, '.', ',') }}</h3>
                        <p>TASA {{ number_format($tasaBanplus, 2, '.', ',') }}</p>
                        <p>BANCO BANPLUS</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <a href="#" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>


@stop

{{-- @section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        console.log('Hi!');
    </script>
@stop --}}
