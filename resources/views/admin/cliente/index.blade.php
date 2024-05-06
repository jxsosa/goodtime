@extends('adminlte::page')
@section('title', 'Clientes')

@section('content_header')

<a class="btn btn-secondary float-right " href="{{route('admin.cliente.create')}}">Agregar cliente</a>
    <h1>Lista de Clientes</h1>
@stop
@section('content')

    @if (session('info'))
        <div class="alert alert-success">
            <strong>{{session('info')}}</strong>
        </div>

    @endif
    @php
    use App\Models\Movimiento;
    $entrada = 0;
    $salida = 0;
    $saldo = 0;
    $bs=0; 
    $movimientos=Movimiento::all();      
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
                <span class="info-box-number">$ {{number_format($saldo , 2, '.', ',')  }}</span>
            </div>
        </div>
    </div>
    
    
    </div>
    <div class="card">

        {{-- <div class="card-header">
           
        </div> --}}
        {{-- <div class="card-body">
           <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Telefono</th>
                    <th colspan="2"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clientes as $cliente)
                    <tr>
                        <td>{{$cliente->id}}</td>
                        <td><a href="{{route('admin.cliente.show', $cliente)}}">{{$cliente->nombre}}</a></td>
                        <td>{{$cliente->email}}</td>
                        <td>{{$cliente->telefono}}</td>
                        <td width="10px">
                            <a class="btn btn-primary btn-sm" href="{{route('admin.cliente.edit', $cliente)}}">Editar</a>
                        </td>
                        <td width="10px">
                            <form action="{{route('admin.cliente.destroy', $cliente)}}" method="POST">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>                                
                            </form>
                        </td>
                    </tr>
                @endforeach

            </tbody>

           </table>
        </div> --}}
        <div class="card-body">@livewire('cliente-table')</div>
        
    </div>
     {{-- para agregarle estilo a la alertas com sweetalert --}}
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
     <script>
          Livewire.On('Atencion',function(message){
             Swal.fire({
                 position: "top-end",
                 icon: "success",
                 title: message,
                 showConfirmButton: false,
                 timer: 1500
                 });
         } )
 
         Livewire.On('error',function(message){
             Swal.fire({
                 icon: "error",
                 title: "Oops...",
                 text: message,
                 // footer: '<a href="#">Why do I have this issue?</a>'
                 });
         } )
     </script>
@stop
@section('js')
   
@stop
