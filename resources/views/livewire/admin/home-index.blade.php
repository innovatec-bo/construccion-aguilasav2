<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header">Todos los incidentes 72 dias sin incidentes</div>
            <div class="card-body">
                <!-- /.row-->
                <div class="table-responsive">
                    <table class="table border mb-0">
                        <thead class="table-light fw-semibold">
                            <tr class="align-middle">
                                <th>Proyecto</th>
                                <th class="text-center">Detalle</th>
                                <th>Estatus en<br>incidente</th>
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
                                        <div>{{$incident->project->code_pro}}</div>
                                        <div class="small text-medium-emphasis"><span>New</span> |
                                            Registered: Jan 1, 2020</div>
                                    </td>
                                    <td class="text-start">
                                        {{$incident->detail_inc}}
                                    </td>
                                    <td>
                                        <div class="clearfix">
                                            <div class="float-start">
                                                <div class="fw-semibold">50%</div>
                                            </div>
                                            <div class="float-end"><small class="text-medium-emphasis">Jun
                                                    11, 2020 - Jul 10, 2020</small></div>
                                        </div>
                                        <div class="progress progress-thin">
                                            <div class="progress-bar bg-success" role="progressbar"
                                                style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                                                aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        {{$incident->project->status->status_name_pst}}
                                    </td>
                                    <td>
                                        <div class="small text-medium-emphasis">Last login</div>
                                        <div class="fw-semibold">10 sec ago</div>
                                    </td>
                                    <td>
                                        {{$incident->author->fullName}}
                                    </td>
                                    <td>
                                        <p class="small">
                                            @if ($incident->created_at)
                                                {{$incident->created_at->translatedFormat('D d M Y')}}
                                            @else
                                                {{$incident->createdon_inc->format('d/m/Y H:i:s')}}
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
    <!-- /.col-->
</div>