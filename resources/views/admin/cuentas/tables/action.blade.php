<div class="flex d-inline p-3 ">
    <a href="{{route('admin.cuentas.show', [
        'cuentum'=>$id,
    ])}}" class="btn btn-info btn-sm">Ver</a>
    
    <a href="{{route('admin.cuentas.edit', [
        'cuentum'=>$id,
    ])}}" class="btn btn-primary btn-sm">Editar</a>
    <a href="{{ route('admin.cuenta.estado_cuenta', ['cuentum' => $id]) }}"  class="btn btn-sm btn-outline-danger">
        <i class="glyphicon glyphicon-file"></i>PDF</a>

    {{-- <form class="d-inline p-3" action="{{route('admin.cuentas.destroy', [
        'cuentum'=>$id,
        ])}}" method="POST">
        @csrf
        @method('delete')
        <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>                                
    </form> --}}

</div>