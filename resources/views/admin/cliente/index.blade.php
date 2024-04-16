@extends('adminlte::page')
@section('title', 'GoodTime')

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
    <div class="card">

        {{-- <div class="card-header">
           
        </div> --}}
        <div class="card-body">
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
        </div>
    </div>
@stop

