@props(['movimientos'])
{{-- <div class="card ">
    <div class="card-body ">        
             
        @php
            $entrada=0;
            $salida=0;
            $saldo=0;
        @endphp 
                            
        @foreach ($movimientos as $movimiento)
            @if ($movimiento->tipo=="entrada")
                @php
                    $entrada=$entrada+$movimiento->monto;
                @endphp                       
            @endif
            @if ($movimiento->tipo=="salida")
                @php
                    $salida=$salida+$movimiento->monto;
                 @endphp                 
             @endif                  
                        
        @endforeach 
         <div class="text-left">TOTAL DE ENTRADA: {{$entrada}}</div>
          <div class="text-center">TOTAL DE SALIDA: {{$salida}}</div>
          <div class="text-ri">SALDO: {{$saldo=$entrada-$salida}}</div>
       
    </div>
</div> --}}
<div class="card">  
    
    {{-- datatabla de movimiento --}}
    @livewire('movimiento-table')  

    <div class="card-body">
       {{-- <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Monto</th>
                <th>Tasa</th>
                <th>REF</th>
                
                <th>tipo</th>
                <th>Fecha Entrrega</th>
                <th>Cambio</th>
                <th>Cuenta</th>
                <th>Cliente</th>
               
                <th colspan="2" ></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($movimientos as $movimiento)
                <tr>
                    <td>{{$movimiento->id}}</td>
                    <td>{{$movimiento->monto}}</td>
                    <td>{{$movimiento->tasa}}</td>
                    <td>{{$movimiento->ref}}</td>
                    
                    <td>{{$movimiento->tipo}}</td>
                    <td>{{$movimiento->fecha_entrega}}</td>
                    <td>{{$movimiento->cambio->nombre}}</td>
                    <td>{{$movimiento->cuenta->nombre}}</td>
                    <td>{{$movimiento->cliente->nombre}}</td>
                    
                    
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

       </table> --}}

    </div>
    {{-- {{$movimientos->links()}} --}}
</div>