@extends('adminlte::page')
@section('title', 'Movimientos')

@section('content_header')
<a class="btn btn-secondary float-right " href="{{route('admin.movimientos.create')}}">Agregar moviemientos</a>
    <h1>Listar los movimientos</h1>
@stop

@section('content')
@if (session('info'))
        <div class="alert alert-success">
            <strong>{{session('info')}}</strong>
        </div>

    @endif
   
   <x-card-movimientos :movimientos="$movimientos" />
    
@stop