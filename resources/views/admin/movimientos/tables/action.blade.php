<div class="flex d-inline p-3">
    {{-- <a href="{{route('admin.movimientos.show', [
        'movimiento'=>$id,
    ])}}" class="btn btn-info btn-sm">Ver</a> --}}
    
    <a href="{{route('admin.movimientos.edit', [
        'movimiento'=>$id,
    ])}}" class="btn btn-primary btn-sm">Editar</a>

    {{-- <form class="d-inline p-3" action="{{route('admin.movimientos.destroy', [
        'movimiento'=>$id,
        ])}}" method="POST">
        @csrf
        @method('delete')
        <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>                                
    </form> --}}

</div>