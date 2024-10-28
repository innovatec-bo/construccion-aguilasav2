<div class="card h-100">
    <div class="card-header d-flex justify-content-between">
      <h5 class="card-title m-0 me-2 pt-1 mb-2 d-flex align-items-center"><i class="ti ti-list-details me-3"></i> Actividad</h5>
    </div>
    <div class="card-body pb-xxl-0 ps-0 pe-2 small">
      <ul class="timeline mb-0">
        @foreach ($logs as $log)
        <li class="timeline-item timeline-item-transparent">
          <span class="timeline-point timeline-point-primary"></span>
          <div class="timeline-event">
            <div class="timeline-header mb-3">
              <h6 class="mb-0 small">
                @if ($log->status)
                    {{ $log->status->status_name_pst }}
                @endif
              </h6>
              <small class="text-muted">12 min ago</small>
            </div>
            <p class="mb-2">
              Invoices have been paid to the company
            </p>
            <div class="d-flex align-items-center mb-1">
              <div class="badge bg-lighter rounded-3">
                <img src="../../assets//img/icons/misc/pdf.png" alt="img" width="15" class="me-2">
                <span class="h6 mb-0 text-body">invoices.pdf</span>
              </div>
            </div>
          </div>
        </li>
        @endforeach
      </ul>
    </div>
  </div>
{{-- <div class="position-relative">
    <div class="overlay d-none" wire:loading.class.remove="d-none" wire:target="loadLogs">
        <div class="spinner-grow" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <style>
        ul.timeline {
            list-style-type: none;
            position: relative;
            padding-left: 1.5rem;
        }

        li.timeline-item {
            margin: 20px 0;
        }

        .timeline-arrow {
            border-top: 0.5rem solid transparent;
            border-right: 0.5rem solid #fff;
            border-bottom: 0.5rem solid transparent;
            display: block;
            position: absolute;
            left: 2rem;
        }

        ul.timeline:before {
            content: ' ';
            background: #cbcbcf;
            display: inline-block;
            position: absolute;
            left: 16px;
            width: 4px;
            height: 100%;
            z-index: 400;
            border-radius: 1rem;
        }

        li.timeline-item::before {
            content: ' ';
            background: #cbcbcf;
            display: inline-block;
            position: absolute;
            border-radius: 50%;
            border: 3px solid #fff;
            left: 11px;
            width: 14px;
            height: 14px;
            z-index: 400;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
        }
    </style>
    <ul class="timeline small">
        @foreach ($logs as $log)
            <li class="timeline-item bg-white rounded ms-3 p-3 shadow" data-keyword="{{ $log->status->keyword_pst }}">

                <div class="timeline-arrow"></div>
                <h2 class="h6 mb-0 fw-semibold d-inline-flex">
                    @if ($log->status)
                        {{ $log->status->status_name_pst }}
                    @endif
                </h2>
                
                <span class="small text-gray d-block">
                    <i class="fa fa-clock-o mr-1"></i>
                    @if ($log->manual_entry_date_psl)
                        {{ $log->manual_entry_date_psl->translatedFormat('l d F Y') }},
                        {{ $log->manual_entry_date_psl->diffForHumans() }}
                    @endif
                </span>
                @php
                    $responsibles = '';
                @endphp
                @foreach ($log->statusLogResponsible as $statusLogResponsible)
                    @php
                    if ($statusLogResponsible->responsible) 
                    {
                        $responsibles .= $statusLogResponsible->responsible->user->fullName . ', ';
                    }
                    @endphp
                @endforeach
                <dl>
                    <dt>Responsable</dt>
                    <dd class="">{{ substr($responsibles, 0, -2) }}</dd>
                    @if (!is_null($log->log_detail_psl) && $log->log_detail_psl != '')
                        <dt>Observaciones</dt>
                        <dd class="">{{ $log->log_detail_psl }}</dd>
                    @endif
                </dl>
                @if ($log->status->keyword_pst == 'approved' && $log->projectBudget)
                    <div class="d-flex justify-content-between border-bottom">
                        <span class="fw-semibold">Total</span>
                        @php
                            $total = $log->projectBudget->design_prb + $log->projectBudget->building_prb + $log->projectBudget->transportation_prb + $log->projectBudget->live_line_prb + $log->projectBudget->right_of_way_prb;
                        @endphp
                        <span class="">{{ number_format($total, 2, '.', ',') }}</span>
                    </div>
                    <div class="d-flex justify-content-between border-bottom">
                        <span class="fw-semibold">Dise&ntilde;o</span>
                        <span class="">{{ number_format($log->projectBudget->design_prb, 2, '.', ',') }}</span>
                    </div>
                    <div class="d-flex justify-content-between border-bottom">
                        <span class="fw-semibold">Construcci&oacute;n</span>
                        <span class="">{{ number_format($log->projectBudget->building_prb, 2, '.', ',') }}</span>
                    </div>
                    <div class="d-flex justify-content-between border-bottom">
                        <span class="fw-semibold">Transporte</span>
                        <span
                            class="">{{ number_format($log->projectBudget->transportation_prb, 2, '.', ',') }}</span>
                    </div>
                    <div class="d-flex justify-content-between border-bottom">
                        <span class="fw-semibold">Linea viva</span>
                        <span
                            class="">{{ number_format($log->projectBudget->live_line_prb, 2, '.', ',') }}</span>
                    </div>
                    <div class="d-flex justify-content-between border-bottom">
                        <span class="fw-semibold">Derecho de via</span>
                        <span
                            class="">{{ number_format($log->projectBudget->right_of_way_prb, 2, '.', ',') }}</span>
                    </div>
                    <div class="d-flex justify-content-between border-bottom">
                        <span class="fw-semibold">Nro. Grafo</span>
                        <span class="">{{ $log->projectBudget->graph_number_prb }}</span>
                    </div>
                    <div class="d-flex justify-content-between border-bottom">
                        <span class="fw-semibold">Nro. Reserva</span>
                        <span class="">{{ $log->projectBudget->reservation_number_prb }}</span>
                    </div>
                @endif
            </li>
        @endforeach
    </ul>
    @if ($hasMorePages)
        <div class="d-grid gap-2">
            <button class="btn btn-primary btn-sm" wire:click="loadLogs">
                Cargar m&aacute;s
            </button>
        </div>
    @endif
</div> --}}