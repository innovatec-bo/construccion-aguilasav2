<div class="position-relative">
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
            <li class="timeline-item bg-white rounded ms-3 p-3 shadow">
                <div class="timeline-arrow"></div>
                <h2 class="h6 mb-0 fw-semibold">
                    @if ($log->status)
                        {{$log->status->status_name_pst}}    
                    @endif
                </h2>
                <span class="small text-gray">
                    <i class="fa fa-clock-o mr-1"></i>
                    @if ($log->manual_entry_date_psl)
                        {{$log->manual_entry_date_psl->translatedFormat('l d F Y')}},
                        {{$log->manual_entry_date_psl->diffForHumans()}}
                    @endif
                </span>
                <p class="text-small mt-1 font-weight-light"><strong>Responsable:</strong>
                    @php
                        $responsibles = '';
                    @endphp
                    @foreach ($log->statusLogResponsible as $statusLogResponsible)
                        @php
                            $responsibles .= $statusLogResponsible->responsible->user->fullName.', '
                        @endphp
                    @endforeach
                    {{substr($responsibles,0,-2)}}
                </p>
            </li>    
        @endforeach
    </ul>
    <div class="d-grid gap-2">
        <button class="btn btn-primary btn-sm" wire:click="loadLogs">
            Cargar m&aacute;s
        </button>
    </div>
</div>
