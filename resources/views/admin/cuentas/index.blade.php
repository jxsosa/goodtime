@extends('adminlte::page')
@section('title', 'GoodTime')

@section('content_header')
    <a class="btn btn-secondary btn-sm float-right" href="{{route('admin.cuentas.create')}}">Nueva Cuenta</a>
    <h1>Mostrar listado de Cuentas</h1>
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
                        <th>Nombre</th>
                        <th colspan="2"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cuentas as $cuenta)
                        <tr>
                            <td>{{$cuenta->id}}</td>
                            <td>{{$cuenta->nombre}}</td>
                            <td width="10px">
                                <a  class="btn btn-primary btn-sm" href="{{route('admin.cuentas.edit', $cuenta)}}">Editar</a>
                            </td>
                            <td width="10px">
                                <form action="{{route('admin.cuentas.destroy', $cuenta)}}" method="POST">
                                @csrf
                                @method('delete')

                                <button class="btn btn-danger btn-sm" type="submit">Eliminar</button>
                                
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>


            </table>
        </div>
    </div>
@stop

