@extends('adminlte::page')

@section('title', 'Salidas duplicadas')

@section('content_header')
    <h1>Salidas duplicadas</h1>
@stop

@section('content')
    <div class="card shadow-lg">
        <div class="card-body">
            <table class="table table-bordered table-sm table-hover table-striped text-sm">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>ID de<br>Proyecto</th>
                        <th>Codigo de<br>Proyecto</th>
                        <th>ID<br>Movimiento</th>
                        <th>Fecha de<br>movimiento</th>
                        <th>Movimiento</th>
                        <th>Clave de<br>Movimiento</th>
                        <th>Tipo</th>
                        <th>Codigo de<br>Material</th>
                        <th>Descripcion de<br>Material</th>
                        <th>Cantidad de<br>Material</th>
                        <th>Proyecto<br>Material</th>
                        <th>Balance</th>
                        <th>Balance</th>
                        <th>Movimientos</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($materialsSummaryToFix as $key => $item)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$item->id_pro}}</td>
                            <td>{{$item->code_pro}}</td>
                            <td class="text-right">{{$item->id_msu}}</td>
                            <td class="text-right">{{$item->entry_date_msu}}</td>
                            <td>{{$item->name_mqt}}</td>
                            <td>{{$item->keyword_mqt}}</td>
                            <td class="text-center">{{$item->movement_type_mqt}}</td>
                            <td class="text-right">{{$item->code_mat}}</td>
                            <td class="text-left">{{$item->description_mat}}</td>
                            <td class="text-right">{{$item->quantity_prm}}</td>
                            <td class="text-right">{{$item->project_material}}</td>
                            <td class="text-right">{{$item->balance}}</td>
                            <td class="text-right">{{$item->balance_string}}</td>
                            <td class="text-right">{{$item->movements}}</td>
                        </tr>    
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
