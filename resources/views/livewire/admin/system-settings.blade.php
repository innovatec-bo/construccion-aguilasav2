<form wire:submit="save" class="row g-6">
    <!-- Navigation -->
    <div class="col-12 col-lg-4">
        <div class="d-flex justify-content-between flex-column mb-4 mb-md-0">
            <h5 class="mb-4">Configuraci&oacute;n</h5>
            <ul class="nav nav-align-left nav-pills flex-column">
                <li class="nav-item mb-1">
                    <a class="nav-link active waves-effect waves-light" href="javascript:void(0);">
                        <i class="icon-base ti tabler-settings icon-sm me-1_5"></i>
                        <span class="align-middle">Sistema</span>
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link waves-effect waves-light" href="{{ route('admin.settings.status-management') }}">
                        <i class="icon-base ti tabler-rosette-discount icon-sm me-1_5"></i>
                        <span class="align-middle">Administraci&oacute;n de estados</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <!-- /Navigation -->

    <!-- Options -->
    <div class="col-12 col-lg-8 pt-6 pt-lg-0">
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card mb-6">
            <div class="card-header">
                <h5 class="m-0">Identidad del Sistema</h5>
                <p class="my-0 card-subtitle">Configura los logotipos y recursos visuales según su destino de uso.</p>
            </div>

            <div class="card-body">
                <div class="row g-4">
                    <!-- 1. Logo del Sistema (Menú / Topbar) -->
                    <div class="col-12 col-md-6">
                        <label class="form-label text-heading fw-semibold">Logo del Sistema (Panel Web)</label>
                        <span class="text-muted d-block small mb-2">Visible en la barra lateral superior izquierda.</span>
                        <div class="mb-3 text-center p-3 border rounded bg-light-subtle">
                            @if ($newAppLogo)
                                <img src="{{ $newAppLogo->temporaryUrl() }}" class="img-fluid" style="max-height: 80px;" alt="Preview Logo Sistema">
                            @elseif ($appLogo)
                                <img src="{{ Storage::disk('public')->url($appLogo) }}" class="img-fluid" style="max-height: 80px;" alt="Logo Sistema">
                            @else
                                <div class="text-muted small py-3">Sin imagen asignada</div>
                            @endif
                        </div>
                        <input type="file" wire:model="newAppLogo" class="form-control" accept="image/*">
                        @error('newAppLogo') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <!-- 2. Logo para Reportes y Notificaciones -->
                    <div class="col-12 col-md-6">
                        <label class="form-label text-heading fw-semibold">Logo para Documentos y Correos</label>
                        <span class="text-muted d-block small mb-2">Utilizado en las exportaciones Excel y correos de notificación.</span>
                        <div class="mb-3 text-center p-3 border rounded bg-light-subtle">
                            @if ($newDocumentLogo)
                                <img src="{{ $newDocumentLogo->temporaryUrl() }}" class="img-fluid" style="max-height: 80px;" alt="Preview Document Logo">
                            @elseif ($documentLogo)
                                <img src="{{ Storage::disk('public')->url($documentLogo) }}" class="img-fluid" style="max-height: 80px;" alt="Document Logo">
                            @else
                                <div class="text-muted small py-3">Sin imagen asignada</div>
                            @endif
                        </div>
                        <input type="file" wire:model="newDocumentLogo" class="form-control" accept="image/*">
                        @error('newDocumentLogo') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <!-- 3. Pin Marker -->
                    <div class="col-12 col-md-6">
                        <label class="form-label text-heading fw-semibold">Pin Marker (Mapas)</label>
                        <span class="text-muted d-block small mb-2">Ícono usado para marcar coordenadas geográficas.</span>
                        <div class="mb-3 text-center p-3 border rounded bg-light-subtle">
                            @if ($newPinMarker)
                                <img src="{{ $newPinMarker->temporaryUrl() }}" class="img-fluid" style="max-height: 55px;" alt="Preview Pin Marker">
                            @elseif ($pinMarker)
                                <img src="{{ Storage::disk('public')->url($pinMarker) }}" class="img-fluid" style="max-height: 55px;" alt="Pin Marker">
                            @else
                                <div class="text-muted small py-3">Sin marcador asignado</div>
                            @endif
                        </div>
                        <input type="file" wire:model="newPinMarker" class="form-control" accept="image/*">
                        @error('newPinMarker') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <!-- 4. Favicon -->
                    <div class="col-12 col-md-6">
                        <label class="form-label text-heading fw-semibold">Favicon</label>
                        <span class="text-muted d-block small mb-2">Ícono de pestaña del navegador (.ico o .png).</span>
                        <div class="mb-3 text-center p-3 border rounded bg-light-subtle">
                            @if ($newFavicon)
                                @if ($newFavicon->isPreviewable())
                                    <img src="{{ $newFavicon->temporaryUrl() }}" class="img-fluid" style="max-height: 48px;" alt="Preview Favicon">
                                @else
                                    <div class="d-flex flex-column align-items-center justify-content-center py-2">
                                        <i class="icon-base ti tabler-file-code fs-2 text-primary mb-1"></i>
                                        <span class="text-muted small">{{ $newFavicon->getClientOriginalName() }}</span>
                                    </div>
                                @endif
                            @elseif ($favicon)
                                <img src="{{ Storage::disk('public')->url($favicon) }}" class="img-fluid" style="max-height: 48px;" alt="Favicon">
                            @else
                                <div class="text-muted small py-3">Sin favicon asignado</div>
                            @endif
                        </div>
                        <input type="file" wire:model="newFavicon" class="form-control" accept="image/*,.ico">
                        @error('newFavicon') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <!-- Texto al pie de correos / Firma -->
                    <div class="col-12">
                        <label class="form-label text-heading fw-semibold" for="emailFooterText">Texto al pie de correos / Remitente</label>
                        <span class="text-muted d-block small mb-2">Texto que se mostrará como firma o pie de página en los correos y notificaciones enviadas.</span>
                        <input type="text" 
                            id="emailFooterText" 
                            wire:model="emailFooterText" 
                            class="form-control" 
                            placeholder="Ej: Serebo.Admin">
                        @error('emailFooterText') 
                            <span class="text-danger small">{{ $message }}</span> 
                        @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label text-heading fw-semibold" for="enableDetailedTreeTrimming">Activar recorte detallado del árbol</label>
                        <span class="text-muted d-block small mb-2">Habilita el recorte detallado del árbol en la interfaz de usuario, esto permite especificar el tipo de corte</span>
                        <div class="form-check form-switch">
                            <input type="checkbox" 
                                id="enableDetailedTreeTrimming" 
                                wire:model="enableDetailedTreeTrimming" 
                                class="form-check-input">
                            <label class="form-check-label" for="enableDetailedTreeTrimming">Activar recorte detallado del árbol</label>
                        </div>
                        @error('enableDetailedTreeTrimming') 
                            <span class="text-danger small">{{ $message }}</span> 
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-4">
            <button type="submit" class="btn btn-primary waves-effect waves-light" wire:loading.attr="disabled">
                <span wire:loading.remove>Guardar cambios</span>
                <span wire:loading>Guardando cambios...</span>
            </button>
        </div>
    </div>
    <!-- /Options -->
</form>