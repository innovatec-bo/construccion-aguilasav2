@extends('layouts.dashboard-layout')

@section('title', 'Rectificar mano de obra')

@section('breadcrumb')
    {{ Breadcrumbs::render('admin.projects.rectify-manpower') }}
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card card-primary">
                <form method="post" action="">
                    @csrf
                    @method('post')
                    <div class="card-body">
                        {{-- <div class="form-group">
                        <label for="name">Nombre</label>
                        <input type="text" id="name" class="form-control" placeholder="Nombre" name="name" value="{{$permission->name}}">
                        @error('name')
                            <span class="text-warning small"> {{$message}} </span>
                        @enderror
                    </div> --}}
                        <div class="form-group">
                            <label for="exampleInputFile">File input</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="exampleInputFile">
                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text">Upload</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Guardar</button>
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
    {{-- <script> console.log('Hi!'); </script> --}}
@stop
