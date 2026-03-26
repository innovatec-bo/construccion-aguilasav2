<div class="row justify-content-center position-relative">
  <div class="overlay" wire:loading.class="d-flex" wire:target="save,image" style="display:none">
      <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
  </div>
  <div class="col-md-6">
      <div class="card">
          <div class="card-body fv-plugins-bootstrap5">
              {{-- <div class="d-flex align-items-start align-items-sm-center gap-4">
                  @if ($temporaryImageUrl)
                      <img src="{{ $temporaryImageUrl }}" alt="user-avatar" class="d-block w-px-100 h-px-100 rounded" id="uploadedAvatar">
                  @else
                      @if ($image)
                        @dump($image->temporaryUrl())
                          <img src="{{ $image->temporaryUrl() }}" alt="user-avatar" class="d-block w-px-100 h-px-100 rounded" id="uploadedAvatar">
                      @else
                          <img src="{{ asset('admin-theme/img/avatars/default-avatar.jpg') }}" alt="user-avatar" class="d-block w-px-100 h-px-100 rounded" id="uploadedAvatar">
                      @endif
                  @endif
                  <div class="button-wrapper">
                      <label for="upload" class="btn btn-primary me-2 mb-3 waves-effect waves-light" tabindex="0">
                          <span class="d-none d-sm-block">Seleccionar foto</span>
                          <i class="ti ti-upload d-block d-sm-none"></i>
                          <input type="file" wire:model.live="image" id="upload" class="account-file-input" hidden="" accept="image/png, image/jpeg">
                      </label>
                  </div>
              </div>
              <hr class="my-4"> --}}
              <div class="row">
                  <div class="mb-3 col-md-6 fv-plugins-icon-container">
                      <label for="lastName" class="form-label">Apellidos</label>
                      <input class="form-control" type="text" name="lastName" id="lastName" value=""
                          wire:model.live.debounce.1000ms="lastName">
                      @error('lastName')
                          <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                              {{ $message }}
                          </div>
                      @enderror
                  </div>
                  <div class="mb-3 col-md-6 fv-plugins-icon-container">
                      <label for="firstName" class="form-label">Nombres</label>
                      <input class="form-control" type="text" id="firstName" name="firstName" value=""
                          autofocus="" wire:model.live.debounce.1000ms="firstName">
                      @error('firstName')
                          <div
                              class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                              {{ $message }}
                          </div>
                      @enderror
                  </div>
                  <div class="mb-3 col-md-6">
                      <label for="email" class="form-label">Correo</label>
                      <input class="form-control" type="text" id="email" name="email" value=""
                          wire:model.live.debounce.1000ms="email">
                      @error('email')
                          <div
                              class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                              {{ $message }}
                          </div>
                      @enderror
                  </div>
                  <div class="mb-3 col-md-6 fv-plugins-icon-container">
                      {{-- <label for="password" class="form-label">Actualizar contrase&ntilde;a</label> --}}
                    <div class="form-check mb-1 small ps-0">
                        <input class="" id="updatePassword" type="checkbox" value="1" wire:model.live="updatePassword">
                        <label class="" for="updatePassword">Actualizar contrase&ntilde;a</label>
                    </div>
                      <input class="form-control" type="text" name="password" id="password" value=""
                          wire:model.live.debounce.1000ms="password">
                      @error('password')
                          <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                              {{ $message }}
                          </div>
                      @enderror
                  </div>
                  <div class="mb-3 col-md-12">
                      <div class="form-group mb-2">
                          <label class="form-label">Roles</label>
                          @foreach ($roles as $index => $role)
                              <div class="form-check">
                                  <input class="form-check-input" id="checkbox-{{ $role->id }}" type="checkbox"
                                      value="{{ $role->id }}" wire:model.live="selectedRoles">
                                  <label class="form-check-label"
                                      for="checkbox-{{ $role->id }}">{{ $role->name }}</label>
                              </div>
                          @endforeach
                          @error('selectedRoles')
                              <div
                                  class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                  {{ $message }}
                              </div>
                          @enderror
                      </div>
                  </div>
                  <div class="col-md-12">
                      <button type="button" class="btn btn-primary btn-next waves-effect waves-light" wire:click="save">
                          <span class="align-middle d-sm-inline-block d-none me-sm-1">Guardar</span>
                          <i class="ti ti-device-floppy d-block d-sm-none"></i>
                      </button>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>
