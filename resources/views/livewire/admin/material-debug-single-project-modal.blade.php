<div class="modal-dialog position-relative modal-xl">
    <div class="overlay d-none" wire:loading.class="d-flex" wire:target="debug">
        <div class="spinner-grow" style="width: 3rem; height: 3rem;" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Depurar materiales</h5>
        </div>
        <div class="modal-body">
            <p>Se crear&aacute; un movimineto llamado <strong>Depuraci&oacute;n de materiales pendientes en CRE</strong>, este pondra en cero los materiales pendientes de retiro en CRE</p>
        </div>
        <div class="modal-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-small small table-striped table-hover table-sm mb-0">
                    <thead>
                        <tr class="text-center">
                            <th>
                                C&oacute;digo
                            </th>
                            <th>
                                Descripci&oacute;n
                            </th>
                            <th>
                                Proyecto
                            </th>
                            <th>
                                Cantidad<br>Comprometida
                            </th>
                            <th>
                                Retirado<br>de CRE
                            </th>
                            <th>
                                Pendiente por<br>retirar de CRE
                            </th>
                            <th>
                                Entregado<br>al constructor
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($materialSummaries as $materialSummary)
                            <tr>
                                <td class="stacked-info text-end">
                                    {{ $materialSummary->material_code }}
                                </td>
                                <td>
                                    {{ $materialSummary->material_description }}
                                </td>
                                <td class="stacked-info">
                                    {{ $materialSummary->project_code }}
                                    <p class="mb-0 text-info">{{ $materialSummary->project_status_name }}</p>
                                </td>
                                <td class="text-end"> 
                                    {{ number_format($materialSummary->quantity_assigned_materials,'2','.',',') }} 
                                </td>
                                <td class="text-end">
                                    {{ number_format($materialSummary->quantity_picked_up_from_cre,'2','.',',') }}
                                </td>
                                <td class="text-end"> 
                                    {{ number_format($materialSummary->pending_material_in_cre,'2','.',',') }}
                                </td>
                                <td class="text-end"> 
                                    {{ number_format($materialSummary->quantity_materials_delivered_to_builder,'2','.',',') }} 
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-primary" wire:click="debug">Aplicar depuraci&oacute;n</button>
        </div>
    </div>
</div>