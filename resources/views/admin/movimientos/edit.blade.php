@extends('adminlte::page')
@section('title', 'GoodTime')

@section('content_header')
    <h1>Editar un movimientos</h1>
@stop

@section('content')
<div class="card">

    <div class="card-body ">
        <div class="container ">
            {!! Form::model($movimiento, ['route' => ['admin.movimientos.update', $movimiento], 'method'=>'put']) !!}

            {!! Form::hidden('user_id', auth()->user()->id) !!}
            <div class="row row-cols-4">
                <div class="col">
                    <div class="form-grup ">
                        {!! Form::label('bs', 'BS') !!}
                        {!! Form::text('bs', null, ['class' => 'monto1 form-control', 'placeholder' => 'Ingrese el Monto en BS']) !!}

                        @error('bs')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                    </div>
                </div>
                <div class="col">
                    <div class="form-grup">
                        {!! Form::label('tasa', 'TASA') !!}
                        {!! Form::text('tasa', null, [
                            'class' => 'monto1 form-control',
                            'placeholder' => 'Ingrese el Monto de la tasa'
                        ]) !!}

                        @error('tasa')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col">
                    <div class="form-grup">
                        {!! Form::label('monto', 'MONTO $') !!}
                        {!! Form::text('monto', null, ['class' => 'form-control ','readonly','id'=>'monto']) !!}

                        @error('monto')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col">
                    <div class="form-grup">
                        {!! Form::label('ref', 'REF') !!}
                        {!! Form::number('ref', null, ['class' => 'form-control', 'placeholder' => 'Ingrese la REFERENCIA']) !!}

                        @error('ref')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

            </div>
        </div>
        <div class="container ">
            <div class="row row-cols-2">
                <div class="col">
                    <div class="form-grup ">
                        {!! Form::label('descripcion', 'NOTA') !!}
                        {!! Form::text('descripcion', null, [
                            'class' => 'form-control',
                            'placeholder' => 'Ingrese alguna descricion del movimiento',
                        ]) !!}

                        @error('descripcion')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col ">
                    <div class="form-grup align-items-center">
                        {!! Form::label('tipo', 'TIPO') !!}
                        <label class=" m-3">
                            {!! Form::radio('tipo', 'entrada', true) !!} ENTRADA
                        </label>
                        <label class="m-3">
                            {!! Form::radio('tipo', 'salida') !!} SALIDA
                        </label>

                        @error('tipo')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>


            </div>
        </div>
        <div class="container">
            <div class="row row-cols-4">
                <div class="col">
                    <div class="form-grup">
                        {!! Form::label('cliente_id', 'CLIENTE') !!}
                        {!! Form::select('cliente_id', $cliente, null, [
                            'class' => 'form-control',
                            'placeholder' => 'Seleciones el cliente',
                        ]) !!}

                        @error('cliente_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col">
                    <div class="form-grup ">
                        {!! Form::label('cuenta_id', 'CUENTA') !!}
                        {!! Form::select('cuenta_id', $cuenta, null, [
                            'class' => 'form-control',
                            'placeholder' => 'Seleciones la cuenta',
                        ]) !!}

                        @error('cuenta_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col">
                    <div class="form-grup col">
                        {!! Form::label('cambio_id', 'CAMBIO') !!}
                        {!! Form::select('cambio_id', $cambio, null, [
                            'class' => 'form-control',
                            'placeholder' => 'Seleciones el cambio',
                        ]) !!}

                        @error('cambio_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col">
                    <div class="form-grup ">
                        {!! Form::label('fecha_entrega', 'FECHA ENTREGA') !!}
                        {!! Form::date('fecha_entrega', null, [
                            'class' => 'form-control',
                            'placeholder' => 'Ingrese alguna descricion del movimiento',
                        ]) !!}

                        @error('fecha_entrega')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

            </div>
        </div>


    </div>
    <div class="col-auto">
        {!! Form::submit('Actualizar movimiento', ['class' => 'btn btn-primary']) !!}

        {!! Form::close() !!}
    </div>
    <br>

</div>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $(".monto1").on("keyup", function() {
            var precio = parseFloat($("#bs").val().replace(/,/g, '')) || 0;
            var cantidad = parseFloat($("#tasa").val().replace(/,/g, '')) || 0;
            var resultado =parseFloat(precio / cantidad).toFixed(2) ;
            var resultado=parseFloat(resultado).toLocaleString('en-US', {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2
});
            $("#monto").val(resultado);
        });
    });

    $("#bs").on({
            "focus": function(event) {
                $(event.target).select();
            },
            "keyup": function(event) {
                $(event.target).val(function(index, value) {
                    return value.replace(/\D/g, "")
                        .replace(/([0-9])([0-9]{2})$/, '$1.$2')
                        .replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ",");
                });
            }
        });
        $("#tasa").on({
            "focus": function(event) {
                $(event.target).select();
            },
            "keyup": function(event) {
                $(event.target).val(function(index, value) {
                    return value.replace(/\D/g, "")
                        .replace(/([0-9])([0-9]{2})$/, '$1.$2')
                        .replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ",");
                });
            }
        });
        
</script>
@stop