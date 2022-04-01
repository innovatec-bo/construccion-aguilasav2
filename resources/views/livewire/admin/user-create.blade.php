<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card card-primary">
            <form wire:submit.prevent="save()">
                <div class="card-body">
                    <div class="form-group">
                        <label for="firstName">Nombre</label>
                        <input type="text" id="firstName" class="form-control" placeholder="Nombre" wire:model="firstName">
                        @error('firstName')
                            <span class="text-danger small"> {{$message}} </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="lastName">Apellido</label>
                        <input type="text" id="lastName" class="form-control" placeholder="Apellido" wire:model="lastName">
                        @error('lastName')
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
                                <input class="form-check-input" id="checkbox-{{$role->id}}" type="checkbox" value="{{$role->name}}" wire:model="selectedRoles.{{$role->id}}">
                                <label class="form-check-label" for="checkbox-{{$role->id}}">{{$role->name}}</label>
                            </div>    
                        @endforeach
                        @error('selectedRoles.*')
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
