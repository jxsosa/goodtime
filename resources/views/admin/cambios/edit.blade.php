@extends('adminlte::page')
@section('title', 'GoodTime')

@section('content_header')
    <h1>Editar Cambio</h1>
@stop

@section('content')
    @if (session('info'))
        <div class="alert alert-success">
            <strong>{{session('info')}}</strong>
        </div>

    @endif
<div class="card">
    <div class="card-body">
        {!! Form::model($cambio, ['route' => ['admin.cambios.update', $cambio], 'method'=>'put']) !!}

        

        <div class="form-grup">
            {!! Form::label('nombre', 'Nombre') !!}
            {!! Form::text('nombre', null, ['class' => 'form-control', 'placeholder'=>'Ingrese el Nombre del cambio']) !!}
        
            @error('nombre')
                <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
              
        <div class="form-grup">
            
           <br>
            {!! Form::submit('Actualizar cambio', ['class' => 'btn btn-primary']) !!}
        </div>
        
            

        {!! Form::close() !!}
    </div>
</div>    
@stop