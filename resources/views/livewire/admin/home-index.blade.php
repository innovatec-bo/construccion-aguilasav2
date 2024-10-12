<div class="row g-6">
    <!-- Card Border Shadow -->
    <div class="col-lg-3 col-sm-6">
        <div class="card card-border-shadow-primary h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-2">
                    <div class="avatar me-4">
                        <span class="avatar-initial rounded bg-label-primary"><i class="ti ti-truck ti-28px"></i></span>
                    </div>
                    <h4 class="mb-0">42</h4>
                </div>
                <p class="mb-1">On route vehicles</p>
                <p class="mb-0">
                    <span class="text-heading fw-medium me-2">+18.2%</span>
                    <small class="text-muted">than last week</small>
                </p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6">
        <div class="card card-border-shadow-warning h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-2">
                    <div class="avatar me-4">
                        <span class="avatar-initial rounded bg-label-warning"><i
                                class="ti ti-alert-triangle ti-28px"></i></span>
                    </div>
                    <h4 class="mb-0">8</h4>
                </div>
                <p class="mb-1">Vehicles with errors</p>
                <p class="mb-0">
                    <span class="text-heading fw-medium me-2">-8.7%</span>
                    <small class="text-muted">than last week</small>
                </p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6">
        <div class="card card-border-shadow-danger h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-2">
                    <div class="avatar me-4">
                        <span class="avatar-initial rounded bg-label-danger"><i
                                class="ti ti-git-fork ti-28px"></i></span>
                    </div>
                    <h4 class="mb-0">27</h4>
                </div>
                <p class="mb-1">Deviated from route</p>
                <p class="mb-0">
                    <span class="text-heading fw-medium me-2">+4.3%</span>
                    <small class="text-muted">than last week</small>
                </p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6">
        <div class="card card-border-shadow-info h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-2">
                    <div class="avatar me-4">
                        <span class="avatar-initial rounded bg-label-info"><i class="ti ti-clock ti-28px"></i></span>
                    </div>
                    <h4 class="mb-0">13</h4>
                </div>
                <p class="mb-1">Late vehicles</p>
                <p class="mb-0">
                    <span class="text-heading fw-medium me-2">-2.5%</span>
                    <small class="text-muted">than last week</small>
                </p>
            </div>
        </div>
    </div>
























    <!--/ On route vehicles Table -->
    <div class="col-md-12">
        <div class="card mb-4 position-relative shadow-lg">
            <div class="overlay" wire:loading.flex wire:target="previousPage, nextPage, gotoPage, search, roleId">
                <div class="sk-swing sk-primary">
                    <div class="sk-swing-dot"></div>
                    <div class="sk-swing-dot"></div>
                </div>
            </div>
            <div class="card-header">{{ round($lastIncident->created_at->diffInDays(), 0) }} dias sin incidentes</div>
            <div class="card-body p-0">
                <!-- /.row-->
                <div class="table-responsive">
                    <table class="table table-striped table-hover border mb-0 small">
                        <thead class="table-light fw-semibold">
                            <tr class="align-middle">
                                <th>Proyecto</th>
                                <th class="text-center">Detalle</th>
                                <th class="text-center">Estatus en<br>incidente</th>
                                <th class="text-center">Estatus actual</th>
                                <th>Tipo de incidente</th>
                                <th>Autor</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($incidents as $incident)
                                <tr class="align-middle">
                                    <td>
                                        {{ $incident->project->code_pro }}
                                    </td>
                                    <td class="text-start">
                                        {{ $incident->detail_inc }}
                                    </td>
                                    <td class="text-center">
                                        {{ $incident->status->status_name_pst }}
                                    </td>
                                    <td class="text-center">
                                        {{ $incident->project->status->status_name_pst }}
                                    </td>
                                    <td class="text-center">
                                        @if ($incident->incident_type_inc)
                                            {{ $incidentTypes[$incident->incident_type_inc] }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($incident->author)
                                            {{ $incident->author->fullName }}
                                        @endif
                                    </td>
                                    <td>
                                        <p class="mb-0">
                                            @if ($incident->created_at)
                                                {{ $incident->created_at->translatedFormat('l d F Y') }},
                                                {{ $incident->created_at->diffForHumans() }}
                                            @else
                                                {{ $incident->createdon_inc->translatedFormat('l d F Y') }},
                                                {{ $incident->createdon_inc->diffForHumans() }}
                                            @endif
                                        </p>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        {{ $incidents->links(data: ['scrollTo' => false]) }}
    </div>
    <!-- /.col-->
</div>
