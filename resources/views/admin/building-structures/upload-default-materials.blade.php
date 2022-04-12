@extends('adminlte::page')

@section('title', 'Establecer materiales')

@section('content_header')
    <h1>Establecer materiales</h1>
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Debe cargar un archivo que contenga la asociacion de estructuras con sus respectivos materiales</h3>
                </div>
                <form>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="materials">Estructuras y materiales</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="materials" name="materials">
                                    <label class="custom-file-label" for="materials">Seleccione una lista de estructuras con sus respectivos materiales</label>
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
