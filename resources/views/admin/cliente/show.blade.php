@extends('adminlte::page')
@section('title', 'GoodTime')

@section('content_header')
    <h1>{{$cliente->nombre}}</h1>
    <p>{{$cliente->email}} TLF: 
        {{$cliente->telefono}}</p>
    
@stop
@section('content')
@if (session('info'))
        <div class="alert alert-success">
            <strong>{{session('info')}}</strong>
        </div>

    @endif
    <div class="card">       
        <div class="card-body">
           <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Monto</th>
                    <th>Tasa</th>
                    <th>REF</th>
                    <th>Observacion</th>
                    <th>tipo</th>
                    <th>Fecha Entrrega</th>
                    <th colspan="2"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($movimientos as $movimiento)
                    <tr>
                        <td>{{$movimiento->id}}</td>
                        <td>{{$movimiento->monto}}</td>
                        <td>{{$movimiento->tasa}}</td>
                        <td>{{$movimiento->ref}}</td>
                        <td>{{$movimiento->descripcion}}</td>
                        <td>{{$movimiento->tipo}}</td>
                        <td>{{$movimiento->fecha_entrega}}</td>
                        <td width="10px">
                            <a class="btn btn-primary btn-sm" href="{{route('admin.movimientos.edit', $movimiento)}}">Editar</a>
                        </td>
                        <td width="10px">
                            <form action="{{route('admin.movimientos.destroy', $movimiento)}}" method="POST">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>                                
                            </form>
                        </td>
                    </tr>
                @endforeach

            </tbody>

           </table>
        </div>
    </div>
@stop


