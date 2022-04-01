<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card card-primary">
            <form wire:submit.prevent="save()">
                <div class="card-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nombre completo</label>
                        <input type="text" class="form-control" placeholder="Nombre completo" wire:model="name">
                        @error('name')
                            <span class="text-danger small"> {{$message}} </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Correo</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Correo"
                            wire:model="email">
                        @error('email')
                            <span class="text-danger small"> {{$message}} </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Contrase&ntilde;a</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password"
                            wire:model="password">
                        @error('password')
                            <span class="text-danger small"> {{$message}} </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        @foreach ($roles as $role)
                            <div class="form-check">
                                <input class="form-check-input" id="radio-{{$role->id}}" type="radio" value="{{$role->id}}" name="role" wire:model="roleId">
                                <label class="form-check-label" for="radio-{{$role->id}}">{{$role->name}}</label>
                            </div>    
                        @endforeach
                        @error('roleId')
                            <span class="text-danger small"> {{$message}} </span>
                        @enderror
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
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
