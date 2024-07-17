@extends('adminlte::page')
@section('title', 'GoodTime')

@section('content_header')
    <h1>Editar Clientes</h1>
@stop

@section('content')
    @if (session('info'))
        <div class="alert alert-success">
            <strong>{{session('info')}}</strong>
        </div>
    @endif
<div class="card">
    <div class="card-body">
        {!! Form::model($cliente, ['route' => ['admin.cliente.update', $cliente], 'method'=>'put']) !!}

        {!! Form::hidden('user_id', auth()->user()->id) !!}

        <div class="form-grup">
            {!! Form::label('nombre', 'Nombre') !!}
            {!! Form::text('nombre', null, ['class' => 'form-control', 'placeholder'=>'Ingrese el Nombre del cliente']) !!}
        
            @error('nombre')
                <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
        <div class="form-grup">
            {!! Form::label('telefono', 'Telefono') !!}
            {!! Form::text('telefono', null, ['class' => 'form-control', 'placeholder'=>'Ingrese el telefono del cliente']) !!}
          
            @error('telefono')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
        <div class="form-grup">
            {!! Form::label('email', 'Correo') !!}
            {!! Form::email('email', null, ['class' => 'form-control', 'placeholder'=>'Ingrese el correo del cliente']) !!}
        </div>
       
        <div class="form-grup">
            {!! Form::label('direccion', 'Direccion') !!}
            {!! Form::text('direccion', null, ['class' => 'form-control', 'placeholder'=>'Ingrese el direccion del cliente']) !!}
           <br>
            {!! Form::submit('Actualizar cliente', ['class' => 'btn btn-primary']) !!}
        </div>
        
            

        {!! Form::close() !!}
    </div>
</div>    
@stop

{{-- @section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop --}}