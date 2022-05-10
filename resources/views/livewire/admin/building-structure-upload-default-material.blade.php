<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card card-primary shadow-lg">
            <div class="overlay dark d-none" wire:loading.class="d-flex" wire:target="save">
                <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
            </div>
            <div class="card-header">
                <h3 class="card-title">Debe cargar un archivo que contenga la asociacion de estructuras con sus respectivos materiales</h3>
            </div>
            <form wire:submit.prevent="save()">
                <div class="card-body">
                    <div class="form-group">
                        <label for="materials">Estructuras y materiales</label>
                        <div class="input-group" wire:ignore>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="materials" name="materials" wire:model="file">
                                <label class="custom-file-label" for="materials">Seleccione una lista de estructuras con sus respectivos materiales</label>
                            </div>
                        </div>
                        @error('file')
                            <span class="text-warning small"> {{$message}} </span>
                        @enderror
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Cargar lista</button>
                </div>
            </form>
        </div>
    </div>
</div>