@extends('adminlte::page')

@section('title', 'Salidas duplicadas')

@section('content_header')
    <h1>Salidas duplicadas</h1>
@stop

@section('content')
    <div class="card shadow-lg">
        <div class="card-body">
            <table class="table table-bordered table-sm table-hover table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Codigo de<br>Proyecto</th>
                        <th>ID<br>Movimiento</th>
                        <th>Fecha de<br>movimiento</th>
                        <th>Movimiento</th>
                        <th>Descripcion de<br>Material</th>
                        <th>Cantidad <br>Movida</th>
                        <th>Balance</th>
                        <th>Historia de movimientos</th>
                        <th>Movimientos</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 1;  
                    @endphp
                    @foreach ($materialsSummary as $key => $item)
                        <tr>
                            <td>{{$i}}</td>
                            <td>{{$item->code_pro}}</td>
                            <td class="text-right">{{$item->id_msu}}</td>
                            <td class="text-right">{{$item->entry_date_msu}}</td>
                            <td>
                                @if ($item->movement_type_mqt == 'out')
                                    <span class="text-warning">Salida: </span>
                                @else
                                    <span class="text-success">Entrada: </span>        
                                @endif
                                
                                {{$item->name_mqt}}
                            </td>
                            <td class="text-left"><span class="text-info">{{$item->code_mat}}:</span> {{$item->description_mat}}</td>
                            <td class="text-right">{{$item->quantity_prm}}</td>
                            <td class="text-right">{{$item->balance}}</td>
                            <td class="text-right">{{$item->balance_string}}</td>
                            <td class="text-right">{{$item->movements}}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-cogs"></i>
                                    </button>
                                    <div class="dropdown-menu" role="menu" style="">
                                        @can('admin.materials-summary.grouped-movement-details')
                                            <a  wire:loading.class="disabled" target="_blank" class="dropdown-item" href='{{route('admin.materials-summary.grouped-movement-details', ['project' => $item->id_pro,'search' => $item->code_mat])}}'"><i class="fas fa-eye"></i> Detalle de movimiento</a>
                                        @endcan
                                        <form action="{{route('admin.project-materials.destroy', $item->id_prm)}}" method="post">
                                            @method('delete')
                                            @csrf
                                            <button wire:loading.class="disabled" type="submit" onclick="return confirm('Are you sure?')" class="dropdown-item"><i class="fas fa-times"></i> Eliminar registro de salida</button>
                                        </form>
                                        {{-- <a wire:loading.class="disabled" target="_blank" class="dropdown-item" href='{{route('admin.project-materials.destroy', $item->id_prm)}}'"><i class="fas fa-times"></i> Eliminar registro de salida</a> --}}
                                    </div>
                                </div>
                            </td>
                        </tr>    
                        @php
                            $i++;  
                        @endphp
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    @stack('scripts')
    {{-- <script> console.log('Hi!'); </script> --}}
@stop
