<div class="flex d-inline p-3 ">
    <a href="{{route('admin.cliente.show', [
        'cliente'=>$id,
    ])}}" class="btn btn-info btn-sm">Ver</a>
    
    <a href="{{route('admin.cliente.edit', [
        'cliente'=>$id,
    ])}}" class="btn btn-primary btn-sm" >Editar</a>

    <form class="d-inline p-3" action="{{route('admin.cliente.destroy', [
        'cliente'=>$id,
        ])}}" method="POST">
        @csrf
        @method('delete')
        <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>                                
    </form>

</div>