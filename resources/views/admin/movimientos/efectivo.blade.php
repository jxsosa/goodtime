@extends('adminlte::page')
@section('title', 'Efectivo')

@section('content_header')

    <h1>Movimiento efectivo</h1>
@stop

@section('content')

    <div class="card">

        <div class="card-body ">
            <div class="container ">
                {!! Form::open(['route' => 'admin.movimientos.store', 'autocomplete' => 'off', 'onsubmit'=>'return checkSubmit();']) !!}
                @csrf
                {!! Form::hidden('user_id', auth()->user()->id) !!}
                <div class="row row-cols-2">
                    
                    
                    <div class="col">
                        <div class="form-grup">
                            {!! Form::label('monto', 'MONTO $') !!}
                            {!! Form::text('monto', null, ['class' => 'form-control ','id'=>'monto']) !!}

                            @error('monto')
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
                <div class="row row-cols-2">
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
                            {!! Form::label('cuenta_id2', 'CUENTA') !!}
                            {!! Form::select('cuenta_id2', $cuenta, $CuentaDefault, [
                                'class' => 'form-control', 'disabled' => 'disabled',
                                'placeholder' => 'Seleciones la cuenta',
                            ]) !!}
                            
                            
                            {!! Form::hidden('cuenta_id', $CuentaDefault) !!}
                            @error('cuenta_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    
                    {{-- {!! Form::hidden('cuenta_id', '11') !!} --}}
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
            {!! Form::submit('Crear Efectivo', ['class' => 'btn btn-primary', 'id'=>'btsubmit']) !!}

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

    $("#monto").on({
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
<script>
    function checkSubmit() {
        document.getElementById("btsubmit").value = "Enviando...";
        document.getElementById("btsubmit").disabled = true;
        return true;
    }
</script>
@stop
