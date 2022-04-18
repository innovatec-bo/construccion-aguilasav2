<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card shadow-lg">
            <div class="card-header">
                <input class="form-control form-control-sm" type="text" wire:model.debounce.1500ms="search" placeholder="Buscar..">
            </div>
            <div class="card-body">
                <div class="overlay dark d-none" wire:loading.class="d-flex" wire:target="previousPage, nextPage, gotoPage, search">
                    <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 10px">ID</th>
                            <th>Proyecto</th>
                            <th>Nro. Grafo</th>
                            <th>Nivel de tension</th>
                            <th>Destino</th>
                            <th style="width: 130px">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($laborDetails as $laborDetail)
                            <tr>
                                <td>{{$laborDetail->id_lad}}</td>
                                <td>{{$laborDetail->project->code_pro}}</td>
                                <td>{{$laborDetail->graph_number_lad}}</td>
                                <td>{{$laborDetail->level_of_tension_lad}}</td>
                                <td>{{$laborDetail->destiny_lad}}</td>
                                <td>
                                    {{-- <button type="button" wire:loading.class="disabled" class="btn btn-primary btn-sm" onclick="window.location.href='{{route('admin.users.edit', $user)}}'"><i class="fas fa-pen"></i></button> --}}
                                    <button type="button"  wire:loading.class="disabled" class="btn btn-secondary btn-sm" onclick="window.location.href='{{route('admin.labor-details.show', $laborDetail)}}'"><i class="fas fa-eye"></i></button>
                                    {{-- <form method="post" action="{{route('admin.users.destroy',$user)}}" class="d-inline">
                                        @method('delete')
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                                    </form> --}}
                                </td>
                            </tr>    
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-footer clearfix">
                {{ $laborDetails->links() }}
            </div>
        </div>
    </div>
</div>