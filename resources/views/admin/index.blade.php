@extends('adminlte::page')
@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    @php
        use App\Models\Movimiento;
        use App\Models\Cuenta;
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
        $movimientos = Movimiento::all();
    @endphp

    @foreach ($movimientos as $movimiento)
        @if ($movimiento->tipo == 'entrada')
            @php
                $entrada = $entrada + $movimiento->monto;

                if (substr_compare($movimiento->cuenta->nombre, 'EFECTIVO', 0, 7) == 0) {
                    $efectivo = $efectivo + $movimiento->monto;
                }
                if (substr_compare($movimiento->cuenta->nombre, 'USDT', 0, 3) == 0) {
                    $usdt = $usdt + $movimiento->monto;
                }

                if (substr_compare($movimiento->cuenta->nombre, 'BANESCO', 0, 5) == 0) {
                    $BanescoMonto = $BanescoMonto + $movimiento->monto;
                    $banesco = $banesco + $movimiento->bs;
                    $bs = $bs + $movimiento->bs;
                }
                if (substr_compare($movimiento->cuenta->nombre, 'VENEZUELA', 0, 8) == 0) {
                    $VenezuelaMonto = $VenezuelaMonto + $movimiento->monto;
                    $venezuela = $venezuela + $movimiento->bs;
                    $bs = $bs + $movimiento->bs;
                }
                if (substr_compare($movimiento->cuenta->nombre, 'MERCANTIL', 0, 8) == 0) {
                    $MercantilMonto = $MercantilMonto + $movimiento->monto;
                    $mercantil = $mercantil + $movimiento->bs;
                    $bs = $bs + $movimiento->bs;
                }
                if (substr_compare($movimiento->cuenta->nombre, 'PROVINCIAL', 0, 9) == 0) {
                    $ProvincialMonto = $ProvincialMonto + $movimiento->monto;
                    $provincial = $provincial + $movimiento->bs;
                    $bs = $bs + $movimiento->bs;
                }
                if (substr_compare($movimiento->cuenta->nombre, 'BANPLUS', 0, 6) == 0) {
                    $BanplusMonto = $BanplusMonto + $movimiento->monto;
                    $banplus = $banplus + $movimiento->bs;
                    $bs = $bs + $movimiento->bs;
                }

            @endphp
        @endif
        @if ($movimiento->tipo == 'salida')
            @php
                $salida = $salida + $movimiento->monto;

                if (substr_compare($movimiento->cuenta->nombre, 'EFECTIVO', 0, 7) == 0) {
                    $efectivo = $efectivo - $movimiento->monto;
                }
                if (substr_compare($movimiento->cuenta->nombre, 'USDT', 0, 3) == 0) {
                    $usdt = $usdt - $movimiento->monto;
                }

                if (substr_compare($movimiento->cuenta->nombre, 'BANESCO', 0, 5) == 0) {
                    $BanescoMonto = $BanescoMonto - $movimiento->monto;
                    $banesco = $banesco - $movimiento->bs;
                    $bs = $bs - $movimiento->bs;
                }
                if (substr_compare($movimiento->cuenta->nombre, 'VENEZUELA', 0, 8) == 0) {
                    $VenezuelaMonto = $VenezuelaMonto - $movimiento->monto;
                    $venezuela = $venezuela - $movimiento->bs;
                    $bs = $bs - $movimiento->bs;
                }
                if (substr_compare($movimiento->cuenta->nombre, 'MERCANTIL', 0, 8) == 0) {
                    $MercantilMonto = $MercantilMonto - $movimiento->monto;
                    $mercantil = $mercantil - $movimiento->bs;
                    $bs = $bs - $movimiento->bs;
                }
                if (substr_compare($movimiento->cuenta->nombre, 'PROVINCIAL', 0, 9) == 0) {
                    $ProvincialMonto = $ProvincialMonto - $movimiento->monto;
                    $provincial = $provincial - $movimiento->bs;
                    $bs = $bs - $movimiento->bs;
                }
                if (substr_compare($movimiento->cuenta->nombre, 'BANPLUS', 0, 6) == 0) {
                    $BanplusMonto = $BanplusMonto - $movimiento->monto;
                    $banplus = $banplus - $movimiento->bs;
                    $bs = $bs - $movimiento->bs;
                }

            @endphp
        @endif
    @endforeach
    @php
        $saldo = $entrada - $salida;

        if ( $banesco ==0) {
            $BanescoMonto=0;
        }
        if ($venezuela ==0) {
            $VenezuelaMonto=0;
        }
        if ($mercantil ==0) {
            $MercantilMonto=0;
        }
        if ($provincial ==0) {
            $ProvincialMonto=0;
        }
        if ($banplus ==0) {
            $BanplusMonto=0;
        }
        $ganacias= $efectivo+$usdt-$BanplusMonto-$ProvincialMonto-$MercantilMonto-$VenezuelaMonto-$BanescoMonto;

        if ($BanescoMonto ===0) {
            $BanescoMonto=1;
        }
        if ($VenezuelaMonto ===0) {
            $VenezuelaMonto=1;
        }
        if ($MercantilMonto ===0) {
            $MercantilMonto=1;
        }
        if ($ProvincialMonto ===0) {
            $ProvincialMonto=1;
        }
        if ($BanplusMonto ===0) {
            $BanplusMonto=1;
        } 
      

       
    @endphp

    <div class="container ">
        <div class="row">
            <div class="col-sm-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>$ {{ number_format($ganacias, 2, '.', ',') }}</h3>
                        {{-- <p>SALDO TOTAL {{ number_format($ganacias, 2, '.', ',') }}</p> --}}
                        <p>SALDO TOTAL </p>
                    </div>
                    <div class="icon">

                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <a href="#" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="small-box bg-gradient-primary">
                    <div class="inner">
                        <h3>Bs {{ number_format($bs, 2, '.', ',') }}</h3>
                        <p>TOTAL BS.</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-coins"></i>
                    </div><i <a href="#" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                        </a>
                </div>
            </div>
        </div>
        <div class="row">

            <div class="col-sm-6">
                <div class="small-box bg-gradient-Light">
                    <div class="inner">
                        <h3>$ {{ number_format($efectivo, 2, '.', ',') }}</h3>
                        <p>TOTAL EFECTIVO</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-hand-holding-usd"></i>
                    </div>
                    <a href="#" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="small-box bg-gradient-warning">
                    <div class="inner">
                        <h3>$ {{ number_format($usdt, 2, '.', ',') }}</h3>
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
        </div>
        <div class="row">
            <div class="col-sm">
                <div class="small-box bg-gradient-dark">
                    <div class="inner">
                        <h3>Bs {{ number_format($venezuela, 2, '.', ',') }}</h3>
                        <p>TASA {{ number_format($venezuela/$VenezuelaMonto, 2, '.', ',') }}</p>
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
                        <p>TASA {{ number_format($banesco/$BanescoMonto, 2, '.', ',') }}</p>
                        <p>BANCO BANESCO</p>
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
                        <p>TASA {{ number_format($provincial/$ProvincialMonto, 2, '.', ',') }}</p>
                        
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
                        <p>TASA {{ number_format($mercantil/$MercantilMonto, 2, '.', ',') }}</p>
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
                        <p>TASA {{ number_format($banplus/$BanplusMonto, 2, '.', ',') }}</p>
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

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        console.log('Hi!');
    </script>
@stop
