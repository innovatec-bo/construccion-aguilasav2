<div class="modal-dialog">
    <div class="modal-content">
        <div class="overlay d-none" wire:loading.class.remove="d-none" wire:target="save">
            <div class="spinner-grow" style="width: 3rem; height: 3rem;" role="status">
                <span class="visually-hidden">Loading...</span>
              </div>
        </div>
        <div class="modal-header">
            <h5 class="modal-title">Moviendo <strong>{{ $project->code_pro }}</strong> a
                <strong>{{ $status->status_name_pst }}</strong></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row g-3">
                @switch($status->keyword_pst)
                {{-- ################################################### Stakes ############################# --}}
                    @case('stakes')
                        <div class="col-md-6">
                            <label>Fecha de movimiento</label>
                            <div class="input-group date">
                                <input class="form-control" type="text" placeholder="dd/mm/yyyy">
                                <span class="input-group-text input-group-append" id="basic-addon2"><i class="fa fa-calendar"></i></span>
                            </div>
                            @error('entryDate') <span class="text-danger small mt-0">{{ $message }}</span>@enderror 
                        </div>
                        <div class="col-12" wire:ignore>
                            <label>Estaqueadores</label>
                            <select id="responsible-list" class="" multiple>
                                <option value=""></option>
                                @foreach ($stakers as $user)
                                    <option value="{{$user->id_usr}}"
                                         data-name='{{$user->firstname_usr}}' data-last-name="{{$user->lastname_usr}}" data-email="{{$user->email_usr}}" data-phone="{{$user->phone_usr}}">{{$user->fullName}}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('responsibleList') <span class="text-danger small mt-0">{{ $message }}</span>@enderror 
                        <div class="col-12">
                            <label>Detalle</label>
                            <textarea class="form-control" wire:model.live="detail" rows="2"></textarea>
                        </div>
                    @break

                    @default
                        Sin definir
                @endswitch
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-primary" wire:click="save">Guardar</button>
        </div>
    </div>
    
    <script>
        $(function() {
            startResponsibleList();
            function startResponsibleList()
            {
                $("#responsible-list").selectize({
                    onChange:function(id, e){
                        @this.set('responsibleList',id);
                    },
                });
            }
            $('.input-group.date').datepicker({
                language: "es",
                autoclose: true
            });
            $('.input-group.date').on('changeDate', function(e) {
                let date = null;
                if (e.date !== undefined) 
                {
                    date = moment(e.date).format('DD-MM-YYYY');
                    @this.set('entryDate', date);
                }
            });
        });
    </script>
</div>
