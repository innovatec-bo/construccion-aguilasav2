<div class="row invoice-preview justify-content-center row-gap-4 position-relative">
    <div class="overlay" wire:loading.flex wire:target="refreshComponent,showModal">
        <div class="sk-swing sk-primary">
            <div class="sk-swing-dot"></div>
            <div class="sk-swing-dot"></div>
        </div>
    </div>
    <!-- Invoice -->
    <div class="col-12 mb-md-0 mb-6">
        <div class="card invoice-preview-card p-sm-12 p-6">
            <div class="card-body invoice-preview-header rounded">
                <div class="d-flex justify-content-between flex-xl-row flex-md-column flex-sm-row flex-column align-items-xl-center align-items-md-start align-items-sm-center align-items-start">
                    <div class="mb-xl-0 mb-4 text-heading mx-auto">
                        <div class="d-flex svg-illustration mb-6 gap-2 align-items-center">
                            <span class="app-brand-text fw-bold fs-4 ms-50 text-uppercase">Formulario diario de registro de podas urbanas</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body px-0 pb-0">
                <div class="row mb-4">
                    <div class="col-xl-6 col-md-12 col-sm-7 col-12">
                        <h6>Detalles:</h6>
                        <table>
                            <tbody>
                                <tr>
                                    <td class="pe-4">Proyecto:</td>
                                    <td class="fw-medium">{{$project->code_pro}}</td>
                                </tr>
                                <tr>
                                    <td class="pe-4">Encargado del proyecto:</td>
                                    <td>{{$project->statusDetail(2)['responsible']}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button 
                            class="btn btn-primary" 
                            type="button"
                            wire:click="$dispatch('showModal', {data: {'alias' : 'admin.tree-pruning-create','params' :{'projectBudget':{{$projectBudget}} }}})"
                            >
                            <span>
                                <i class="ti ti-plus me-md-1"></i>
                                <span class="d-md-inline-block d-none">Agregar poda</span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 mb-md-0 mb-6">
        <div class="table-responsive border border-bottom-0 border-top-0 rounded">
          <table class="table table-bordered table-sm table-hover table-striped mb-0 small">
            <thead>
              <tr class="text-center">
                <th class="px-2">Nro<br>&Aacute;rbol</th>
                <th class="px-2">Fecha</th>
                <th class="px-2">Especie</th>
                <th class="px-2">UTM<br>XCOORD</th>
                <th class="px-2">UTM<br>YCOORD</th>
                <th class="px-2">Barrio</th>
                <th class="px-2">Unidad Vecinal</th>
                <th class="px-2">Manzana</th>
                <th class="px-2">Distrito</th>
                <th class="px-2">Calidad</th>
                <th class="px-2">Tipo de poda</th>
                <th class="px-2">Antes</th>
                <th class="px-2">Despu&eacute;s</th>
                <th class="px-2"><i class="ti ti-dots-vertical"></i></th>
              </tr>
            </thead>
            <tbody>
                @foreach ($projectBudget->treePruning as $treePruning)
                <tr>
                    <td class="px-2 text-center">{{$treePruning->tree_number}}</td>
                    <td class="px-2 text-center">{{$treePruning->pruned_at->format('d-m-Y')}}</td>
                    <td class="px-2">{{$treePruning->specy->name}}</td>
                    <td class="px-2 text-center">{{round($treePruning->utm_x,2)}}</td>
                    <td class="px-2 text-center">{{round($treePruning->utm_y,2)}}</td>
                    <td class="px-2">{{$treePruning->neighborhood}}</td>
                    <td class="px-2">{{$treePruning->neighborhood_unit}}</td>
                    <td class="px-2">{{$treePruning->block}}</td>
                    <td class="px-2">{{$treePruning->district}}</td>
                    <td class="px-2 text-center">{{$treePruning->quality}}</td>
                    <td class="px-2 text-center">{{$treePruning->pruning_type}}</td>
                    <td class="px-2">
                        <div class="avatar avatar rounded-2 bg-label-secondary mx-auto">
                            <img src="{{$treePruning->getFirstMediaUrl('before','sm')}}"class="rounded-2">
                        </div>
                    </td>
                    <td class="px-2">
                        <div class="avatar avatar rounded-2 bg-label-secondary mx-auto">
                            <img src="{{$treePruning->getFirstMediaUrl('after','sm')}}" class="rounded-2">
                        </div>
                    </td>
                    <td class="px-2 text-center">
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-dots-vertical"></i></button>
                            <div class="dropdown-menu" style="">
                                @can('admin.tree-prunings.edit')
                                    <a class="dropdown-item waves-effect" wire:loading.class="disabled" target="_blank" href="{{route('admin.tree-prunings.edit', $treePruning)}}">
                                        <i class="ti ti-edit me-1"></i> Editar
                                    </a>
                                @endcan
                                @if (Auth::user()->email == 'jair@twiiti.com')
                                    <a class="dropdown-item waves-effect" 
                                    wire:loading.class="disabled" href="javascript:void(0);"
                                    wire:click="$dispatch('showModal', {data: {'alias' : 'confirm-delete-modal','size':'modal-sm','params' :{objectToDelete:{{ $treePruning->id }}, model:'App\\Models\\TreePruning' }}})"
                                    >
                                        <i class="ti ti-trash me-1"></i> Eliminar
                                    </a>
                                @endif
                            </div>
                        </div>
                    </td>
                </tr>      
                @endforeach
            </tbody>
          </table>
        </div>
    </div>
    <!-- /Invoice -->
  </div>