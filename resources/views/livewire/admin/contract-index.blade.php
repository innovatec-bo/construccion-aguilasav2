<div class="row position-relative">
    <div class="overlay d-none" wire:loading.class.remove="d-none"
        wire:target="previousPage, nextPage, gotoPage, projectCode, workAreaSelected, statusSelected">
        <div class="spinner-grow" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    @can('admin.contracts.create')
        <div class="col-md-2">
            <div class="form-group">
                <label>&nbsp;</label>
                <a href="javascript:void(0);" wire:click="$emit('showModal','admin.contract-create-modal')" class="btn btn-primary btn-sm form-control"
                    type="button">Nuevo contrato</a>
            </div>
        </div>
    @endcan
    <div class="col-md-12 mt-4">
        <div class="row">
            @foreach ($contracts as $contract)
                <div class="col-sm-6 col-lg-3">
                    <div class="card text-white bg-info shadow-lg">
                        <div class="card-body">
                            <div class="fs-4 fw-semibold">Bs.
                                {{ number_format($contract->amount_con, 2, '.', ',') }}</div>
                            <div>Nro. {{ $contract->contract_number_con }}</div>
                            <div class="d-flex justify-content-between">
                                <div class="float-end ms-1">
                                    <small class="">
                                        Desde el {{$contract->start_date_con->translatedFormat('l d F Y')}} hasta el
                                        {{$contract->expiration_date_con->translatedFormat('l d F Y')}}
                                    </small>
                                </div>
                            </div>
                            @php
                                $start = $contract->start_date_con->timestamp;
                                $end = $contract->expiration_date_con->timestamp;
                                $timespan = $end - $start;
                                $current = Carbon\Carbon::now()->timestamp - $start;
                                $progress = $current / $timespan;
                                $remaining = (1 - $progress) * 100;
                            @endphp
                            <div class="progress progress-white progress-thin my-2">
                                <div class="progress-bar" role="progressbar" style="width: {{100-$remaining}}%"
                                    aria-valuenow="{{100-$remaining}}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        @can('admin.contracts.edit')
                            <div class="card-footer px-3 py-2">
                                <a class="btn-block text-medium-emphasis-inverse d-flex justify-content-between align-items-center" href="javascript:void(0);" wire:click="$emit('showModal','admin.contract-edit-modal', {{$contract}})">
                                    <span class="small fw-semibold">Editar</span>
                                    <x-coreui-icon svgClass="icon" icon="cil-pencil"/>
                                </a>
                            </div>    
                        @endcan
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
