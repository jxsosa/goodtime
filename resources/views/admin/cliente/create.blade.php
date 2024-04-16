@extends('adminlte::page')
@section('title', 'GoodTime')

@section('content_header')
    <h1>Crear Cliente</h1>
@stop

@section('content')
<div class="card">
        <div class="card-body">
            {!! Form::open(['route' => 'admin.cliente.store']) !!}

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
            </div>
            <br>
                {!! Form::submit('Crear cliente', ['class' => 'btn btn-primary']) !!}

            {!! Form::close() !!}
        </div>
</div>    
@stop

