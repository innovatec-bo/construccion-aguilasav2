@extends('adminlte::page')

@section('title', 'Cargar lista inicial de materiales')

@section('content_header')
    <h1>Cargar lista inicial de materiales</h1>
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Ingrese un codigo de proyecto y seleccione un archivo con la lista de materiales</h3>
                </div>
                <form>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="project">Proyecto</label>
                            <input type="text" class="form-control" id="project" name="project" placeholder="Codigo de proyecto">
                        </div>
                        <div class="form-group">
                            <label for="materials">Lista de materiales</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="materials" name="materials">
                                    <label class="custom-file-label" for="materials">Seleccione una lista de materiales</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Cargar lista</button>
                    </div>
                </form>
            </div>
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
