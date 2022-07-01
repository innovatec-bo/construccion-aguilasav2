@extends('adminlte::page')

@section('title', 'Marcar como resuelto')

@section('content_header')
    <h1>Marcar como resuelto</h1>
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card card-primary shadow-lg">
                <form action="{{route('admin.external-observations.mark-as-fixed-update', $externalObservation)}}" method="post">
                    @method('post')
                    @csrf
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
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Fecha de la correcci&oacute;n</label>
                                    <input type="text" name="fixed_date_efo" value="{{date('d/m/Y H:i:s')}}" class="form-control" placeholder="dd/mm/yyyy hh:mm:ss" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy HH:MM:ss" inputmode="numeric">
                                    @error('fixed_date_efo')
                                        <span class="text-warning small"> {{$message}} </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Detalle de la correcci&oacute;n</label>
                                    <textarea class="form-control" name="fix_detail_efo" rows="3" placeholder="Ingrese el detalle de la correccion ..."></textarea>
                                    @error('fix_detail_efo')
                                        <span class="text-warning small"> {{$message}} </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        
                    </div>
                    <div class="card-footer">
                        <h6 class="text-center text-info" wire:loading wire:target="login">
                            <div class="spinner-border text-secondary" role="status">
                                <span class="visually-hidden">@lang('Loading...')</span>
                            </div>
                        </h6>
                        <div wire:loading.remove wire:target="save">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                            <a class="btn btn-danger" href="{{url()->previous()}}">Cancelar</a>
                        </div>
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
    <script>
        $('[data-inputmask-alias]').inputmask();
    </script>
    {{-- <script> console.log('Hi!'); </script> --}}
@stop