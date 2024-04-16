@extends('adminlte::page')
@section('title', 'GoodTime')

@section('content_header')
    <h1>Crear un nuevo  los cambios</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        {!! Form::open(['route' => 'admin.cambios.store']) !!}

        <div class="form-grup">
            {!! Form::label('nombre', 'Nombre') !!}
            {!! Form::text('nombre', null, ['class' => 'form-control', 'placeholder'=>'Ingrese el Tipo de cambio']) !!}
        
            @error('nombre')
                <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
       
        <br>
            {!! Form::submit('Crear Cambio', ['class' => 'btn btn-primary']) !!}

        {!! Form::close() !!}
    </div>
</div> 
@stop
