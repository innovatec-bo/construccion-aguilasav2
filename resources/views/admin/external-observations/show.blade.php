@extends('adminlte::page')

@section('title', 'Detalle de observacion')

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h1>Detalle de observacion</h1>
        </div>
        <div class="col-sm-6">
            {{ Breadcrumbs::render('admin.external-observations.show', $externalObservation) }}
        </div>
    </div>
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card card-primary shadow-lg">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="firstName">Proyecto</label>
                                <p>{{$externalObservation->project->code_pro}}</p>
                            </div>
                            <div class="form-group">
                                <label for="lastName">Estado en observacion</label>
                                <p>{{$externalObservation->status->status_name_pst}}</p>
                            </div>
                            <div class="form-group">
                                <label for="lastName">Fecha de observacion</label>
                                <p>
                                    {{ $externalObservation->entry_date_efo->format('d-m-Y H:i:s')}}
                                    <small class="badge badge-primary">{{ $externalObservation->entry_date_efo->diffForHumans() }}</small>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <figure>
                                <blockquote class="blockquote">
                                    <p>
                                        <i>{!! nl2br($externalObservation->observation_efo) !!}</i>
                                    </p>
                                </blockquote>
                                <figcaption class="blockquote-footer h6">
                                    {{ $externalObservation->fiscal->full_name }}
                                </figcaption>
                            </figure>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script>
        $('[data-inputmask-alias]').inputmask();
    </script>
    {{-- <script> console.log('Hi!'); </script> --}}
@stop