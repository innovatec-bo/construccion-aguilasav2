<div class="row position-relative">
    <div class="overlay d-none" wire:loading.class.remove="d-none"
        wire:target="previousPage, nextPage, gotoPage, projectCode, workAreaSelected, statusSelected">
        <div class="spinner-grow" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">

        <div class="d-flex flex-column justify-content-center">
          <h4 class="mb-1">Contratos</h4>
          <p class="mb-0">Listado de todos los contratos del sistema</p>
        </div>
        <div class="d-flex align-content-center flex-wrap gap-4">
            <div class="d-flex gap-4">
                @can('admin.contracts.create')
                    <a href="javascript:void(0);" 
                    wire:click="$dispatch('showModal', {data: {'alias' : 'admin.contract-create-modal','size':'modal-sm','params' :{}}})"
                    class="btn btn-sm btn-primary waves-effect">Nuevo contrato</a>    
                @endcan
            </div>
        </div>
    
    </div>
    <div class="col-md-12 mt-4">
        <div class="row row-gap-3">
            @foreach ($contracts as $contract)
                <div class="col-sm-6 col-lg-3">
                    <div class="card h-100">
                        <div class="card-header pb-2">
                            <div class="d-flex justify-content-between">
                                <p class="mb-0 text-body">Monto del contrato</p>
                                <p class="card-text fw-medium text-success">{{ $contract->active ? 'Activo' : '' }}</p>
                            </div>
                            <h5 class="card-title mb-1">Bs. {{ number_format($contract->amount_con, 2, '.', ',') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="d-flex gap-2 align-items-center mb-2">
                                        <p class="mb-0">
                                            <strong>Nro.</strong> {{ $contract->contract_number_con }}<br>
                                            <strong>UMBO: </strong>{{ $contract->umbo }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <p>
                                Desde el {{$contract->start_date_con->translatedFormat('l d F Y')}} hasta el
                                        {{$contract->expiration_date_con->translatedFormat('l d F Y')}}
                            </p>
                            @php
                                $start = $contract->start_date_con->timestamp;
                                $end = $contract->expiration_date_con->timestamp;
                                $timespan = $end - $start;
                                $current = Carbon\Carbon::now()->timestamp - $start;
                                $progress = $current / $timespan;
                                $remaining = (1 - $progress) * 100;
                            @endphp
                            <div class="d-flex align-items-center mt-6 mb-3">
                                <div class="progress w-100" style="height: 10px;">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: {{ 100 - $remaining }}%" aria-valuenow="{{ 100 - $remaining }}" aria-valuemin="0" aria-valuemax="100">
                                    </div>
                                </div>
                            </div>
                            @can('admin.contracts.edit')
                                <button type="button" class="btn btn-sm btn-primary w-100 waves-effect waves-light"
                                wire:click="$dispatch('showModal', {data: {'alias' : 'admin.contract-edit-modal','size':'modal-sm','params' :{'contract':{{$contract->id_con}} }}})"
                                >
                                    Editar
                                </button>
                            @endcan
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="col-md-12 mt-4">
        <div class="table-responsive">
            {{ $contracts->links() }}
        </div>
    </div>
</div>
