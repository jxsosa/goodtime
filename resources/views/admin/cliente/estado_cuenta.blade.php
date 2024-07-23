@php
    use App\Models\Movimiento;

    //   $sumaMontosSalida = Movimiento::where('tipo', 'salida')
    //     ->where('cliente_id', $cliente->id) // Reemplaza 'cliente_id' con el nombre correcto de la columna
    //     ->sum('monto');
    // $sumaMontosEntreda = Movimiento::where('tipo', 'entrada')
    //     ->where('cliente_id', $cliente->id) // Reemplaza 'cliente_id' con el nombre correcto de la columna
    //     ->sum('monto');

    $saldo = 0;

    foreach ($movimientos as $movimiento) {
        if ($movimiento->tipo === 'salida') {
            $saldo -= $movimiento->monto;
        } else {
            $saldo += $movimiento->monto;
        }

        // Agrega el saldo al objeto de movimiento
        $movimiento->saldo = $saldo;
    }

    // $saldo=$sumaMontosEntreda-$sumaMontosSalida;
    $saldo = $movimiento->saldo = $saldo;
    $MontoSaldo = 0;
@endphp

<!DOCTYPE html>
<html lang="es">

<head>

    <title>Estado de Cuenta</title>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
</head>

<body>
    <div>
        <div>

            <img src="vendor/adminlte/dist/img/logo.png" alt="Logo de Gootime" width="80" height="80">

        </div>
        <div class="text-rigth">
            <p class="text-uppercase"><b>CLIENTE:</b> {{ $cliente->nombre }} <br>
                @if ($saldo < '0')
                    <h3><span class="badge badge-danger"> <b> SALDO:</b>
                            ${{ number_format($saldo, 2, '.', ',') }}</span></h3>
                @else
                    <h3><span class="badge badge-success"> <b> SALDO:</b>
                            ${{ number_format($saldo, 2, '.', ',') }}</span></h3>
                @endif

            </p>

        </div>


    </div>


    <h1 class="text-center">Estado de Cuenta</h1>

    <table class="table  table-bordered table-sm table-striped">
        <thead class="table-dark text-center">
            <tr>
                <th>Fecha</th>
                <th>Descripción</th>
                {{-- <th>Cuenta</th> --}}
                <th>BS</th>
                <th>TASA</th>
                <th>Monto</th>
                <th>Saldo</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($movimientos as $movimiento)
                <tr>
                    <td class="small"><small>{{ $movimiento->created_at->format('d/m/y h:m') }}</small></td>
                    <td class="small"><small>CUENTA: {{ $movimiento->cuenta->nombre }} .REF: {{ $movimiento->ref }}. {{ $movimiento->descripcion }}</small></td>
                    {{-- <td class="small"><small>{{ $movimiento->cuenta->nombre }}</small></td> --}}
                    <td class="text-center"><small>{{ number_format($movimiento->bs, 2, '.', ',') }}</small></td>
                    <td class="text-center"><small>{{ number_format($movimiento->tasa, 2, '.', ',') }}</small></td>
                    <td class="text-center">
                        @if ($movimiento->tipo === 'entrada')
                            <small>${{ $monto = $movimiento->tipo === 'entrada' ? number_format($movimiento->monto, 2, '.', ',') : number_format($movimiento->monto * -1, 2, '.', ',') }}</small>
                        @else
                            <small
                                class=" text-danger">${{ $monto = $movimiento->tipo === 'entrada' ? number_format($movimiento->monto, 2, '.', ',') : number_format($movimiento->monto * -1, 2, '.', ',') }}</small>
                        @endif

                    </td>
                    {{-- <td class="text-center">$ {{$movimiento->monto }}</td> --}}
                    {{-- <td class="text-center">${{ $MontoSaldo=$MontoSaldo+ $monto}}</td> --}}
                    @if ($loop->first)
                        {{-- Esto es la primera iteración --}}
                        @if ($saldo >= 0)
                            <td class="text-center"><small>${{ number_format($saldo, 2, '.', ',') }}</small></td>
                        @else
                            <td class="text-center text-danger ">
                                <small>${{ number_format($saldo, 2, '.', ',') }}</small></td>
                        @endif

                        @php
                            $montoFormateado = (float) str_replace(',', '', $monto);

                            $saldo = $saldo - $montoFormateado;
                        @endphp
                    @else
                        @if ($saldo >= 0)
                            <td class="text-center"><small>${{ number_format($saldo, 2, '.', ',') }}</small></td>
                        @else
                            <td class="text-center  ">
                                <small class="text-danger">${{ number_format($saldo, 2, '.', ',') }}</small></td>
                        @endif

                        @php
                            //  $monto = number_format($monto, 2); // Formatea el valor con 2 decimales
                            $montoFormateado = (float) str_replace(',', '', $monto);
                            $saldo = $saldo - $montoFormateado;
                        @endphp
                    @endif


                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
