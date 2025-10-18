<div class="position-relative">
    <div class="overlay" wire:loading.flex wire:target="save, before, after">
        <div class="sk-swing sk-primary">
            <div class="sk-swing-dot"></div>
            <div class="sk-swing-dot"></div>
        </div>
    </div>
    <div class="modal-header">
        <h5 class="modal-title">Editar poda</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <form>
            <div class="row">
                <div class="col-md-7">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group mb-3">
                                <label class="form-label" for="treeNumber">N&uacute;mero de &aacute;rbol</label>
                                <input type="text" id="treeNumber" class="form-control form-control-sm" wire:model.live="treeNumber" placeholder="Numero de arbol">
                                @error('treeNumber')
                                    <span class="text-danger small"> {{$message}} </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-3">
                                <label class="form-label" for="species">Especie</label>
                                {{-- <input type="text" id="species" class="form-control form-control-sm" wire:model.live="species"> --}}
                                <select name="species" id="species" class="form-select form-select-sm" wire:model.live="species">
                                    @foreach ($treeSpeciesList->sortBy('name') as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                                @error('species')
                                    <span class="text-danger small"> {{$message}} </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-3">
                                <label class="form-label" for="utmX">Coordinate UTM X</label>
                                <input type="text" id="utmX" class="form-control form-control-sm" wire:model.live="utmX">
                                @error('utmX')
                                    <span class="text-danger small"> {{$message}} </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-3">
                                <label class="form-label" for="utmY">Coordinate UTM Y</label>
                                <input type="text" id="utmY" class="form-control form-control-sm" wire:model.live="utmY">
                                @error('utmY')
                                    <span class="text-danger small"> {{$message}} </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-3">
                                <label class="form-label" for="neighborhood">Barrio</label>
                                <input type="text" id="neighborhood" class="form-control form-control-sm" wire:model.live="neighborhood">
                                @error('neighborhood')
                                    <span class="text-danger small"> {{$message}} </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-3">
                                <label class="form-label" for="neighborhoodUnit">Unidad vecinal</label>
                                <input type="text" id="neighborhoodUnit" class="form-control form-control-sm" wire:model.live="neighborhoodUnit">
                                @error('neighborhoodUnit')
                                    <span class="text-danger small"> {{$message}} </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-3">
                                <label class="form-label" for="block">Manzano</label>
                                <input type="text" id="block" class="form-control form-control-sm" wire:model.live="block">
                                @error('block')
                                    <span class="text-danger small"> {{$message}} </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-3">
                                <label class="form-label" for="district">Distrito</label>
                                <input type="text" id="district" class="form-control form-control-sm" wire:model.live="district">
                                @error('district')
                                    <span class="text-danger small"> {{$message}} </span>
                                @enderror
                            </div>        
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-3">
                                <label class="form-label" for="quality">Calidad</label>
                                <select class="form-select form-select-sm" name="" id="quality" wire:model.live="quality">
                                    <option value="">---</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                </select>
                                @error('quality')
                                    <span class="text-danger small"> {{$message}} </span>
                                @enderror
                            </div>        
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-3">
                                <label class="form-label" for="pruningType">Tipo de poda</label>
                                <input type="text" id="pruningType" class="form-control form-control-sm" wire:model.live="pruningType">
                                @error('pruningType')
                                    <span class="text-danger small"> {{$message}} </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-3">
                                <label class="form-label" for="hasAgreement">Con convenio</label>
                                <select class="form-select form-select-sm" name="" id="hasAgreement" wire:model.live="hasAgreement">
                                    <option value="">---</option>
                                    <option value="1">Si</option>
                                    <option value="0">No</option>
                                </select>
                                @error('hasAgreement')
                                    <span class="text-danger small"> {{$message}} </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Fecha de poda</label>
                                <div class="input-group date prunedAt">
                                    <input class="form-control form-control-sm" type="text" value="{{$prunedAt}}" placeholder="dd/mm/yyyy">
                                    <span class="input-group-text input-group-append" id="basic-addon2"><i class="fa fa-calendar"></i></span>
                                </div>
                                @error('prunedAt')
                                    <span class="text-danger small"> {{$message}} </span>
                                @enderror
                            </div>        
                        </div>
                        <div class="col-12">
                            <div class="form-group mb-3">
                                <label class="form-label" for="notes">Notas</label>
                                <input type="text" id="notes" class="form-control form-control-sm" wire:model.live="notes">
                                @error('notes')
                                    <span class="text-danger small"> {{$message}} </span>
                                @enderror
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="row row-gap-4">
                        <div class="col-12">
                            <label class="form-label">Antes</label>
                            <div class="button-wrapper position-absolute m-1">
                                <label for="before" class="btn btn-xs btn-primary me-2 mb-3 waves-effect waves-light" tabindex="0">
                                    <span class="d-none d-sm-block">Seleccionar foto</span>
                                    <i class="ti ti-upload d-block d-sm-none"></i>
                                    <input type="file" wire:model.live="before" id="before" class="account-file-input" hidden="" accept="image/png, image/jpeg">
                                </label>
                            </div>
                            @if ($temporaryBeforeUrl)
                                <img class="card-img-top" src="{{$temporaryBeforeUrl}}" alt="Card image cap" id="uploadedBefore">
                            @else
                                @if ($before)
                                    <img class="card-img-top" src="{{$before->temporaryUrl()}}" alt="Card image cap" id="uploadedBefore">
                                @else
                                    <img class="card-img-top" src="{{asset('images/no-picture-available.jpg')}}" alt="Card image cap" id="uploadedBefore">
                                @endif
                            @endif
                            @error('before')
                                <small class="text-danger p-2 fw-bold">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label">Despu&eacute;s</label>
                            <div class="button-wrapper position-absolute m-1">
                                <label for="after" class="btn btn-xs btn-primary me-2 mb-3 waves-effect waves-light" tabindex="0">
                                    <span class="d-none d-sm-block">Seleccionar foto</span>
                                    <i class="ti ti-upload d-block d-sm-none"></i>
                                    <input type="file" wire:model.live="after" id="after" class="account-file-input" hidden="" accept="image/png, image/jpeg">
                                </label>
                            </div>
                            @if ($temporaryAfterUrl)
                                <img class="card-img-top" src="{{$temporaryAfterUrl}}" alt="Card image cap" id="uploadedAfter">
                            @else
                                @if ($after)
                                    <img class="card-img-top" src="{{$after->temporaryUrl()}}" alt="Card image cap" id="uploadedAfter">
                                @else
                                    <img class="card-img-top" src="{{asset('images/no-picture-available.jpg')}}" alt="Card image cap" id="uploadedAfter">
                                @endif
                            @endif
                            @error('after')
                                <small class="text-danger p-2 fw-bold">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" wire:click="save">Guardar</button>
    </div>
</div>
@assets
    <link rel="stylesheet" href="{{asset('js/bootstrap-datepicker-1.9.0/css/bootstrap-datepicker3.css')}}">
    <script src="{{asset('js/bootstrap-datepicker-1.9.0/locales/bootstrap-datepicker.es.min.js')}}" defer></script>
    <script src="{{asset('js/bootstrap-datepicker-1.9.0/js/bootstrap-datepicker.js')}}" defer></script>
@endassets
@script
    <script>
        $('.input-group.date').datepicker({
            language: "es",
            format: 'dd/mm/yyyy',
            autoclose: true,
            container: ".modal-body"
        });

        $('.input-group.date').on('changeDate', function(e) {
            let date = null;
            if (e.date !== undefined) 
            {
                date = moment(e.date).format('DD/MM/YYYY');
            }
            if ($(this).hasClass('prunedAt')) 
            {
                @this.prunedAt = date;
                @this.triggerLoading();
            } 
        });
    </script>
@endscript