<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card card-primary shadow-lg">
            <div class="overlay dark d-none" wire:loading.class="d-flex" wire:target="save">
                <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
            </div>
            <div class="card-header">
                <h4 class="card-title">Cada material debe ser &uacute;nico en c&oacute;digo y descripci&oacute;n</h4>
            </div>
            <form wire:submit="save">
                <div class="card-body">
                    <div class="form-group">
                        {!! Form::label('code', 'Codigo') !!}
                        {!! Form::text('code', null, ['class' => 'form-control '.($errors->has('code')?'is-invalid':''), 'wire:model.live' => 'code']) !!}
                        <small class="invalid-feedback">{{ $errors->first('code') }}</small>
                    </div>

                    <div class="form-group">
                        {!! Form::label('description', 'Descripcion') !!}
                        {!! Form::text('description', null, ['class' => 'form-control '.($errors->has('description')?'is-invalid':''), 'wire:model.live' => 'description']) !!}
                        <small class="invalid-feedback">{{ $errors->first('description') }}</small>
                    </div>

                    <div class="form-group">
                        {!! Form::label('unitOfMeasurement', 'Unidad de medida') !!}
                        {!! Form::select('unitOfMeasurement', ['Pza' => 'Pza','M' => 'M'], null, ['id' => 'unitOfMeasurement', 'wire:model.live' => 'unitOfMeasurement', 'class' => 'form-control '.($errors->has('unitOfMeasurement')?'is-invalid':'')]) !!}
                        <small class="invalid-feedback">{{ $errors->first('unitOfMeasurement') }}</small>
                    </div>

                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary" wire:loading.class="disabled" wire:target="save">Guardar</button>
                </div>
            </form>
            
        </div>
    </div>
</div>