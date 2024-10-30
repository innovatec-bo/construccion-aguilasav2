<div class="row justify-content-end">
    <div class="col-md-12">
        <p class="text-center">
            <a class="btn btn-primary fileinput-button" href="javascript:void(0);">Cargar Balance externo de
                materiales</a>
        </p>
        <form id="form-previews" class="my-4" data-parsley-validate='' wire:ignore>
            <div class="files" id="previews">
                <div id="template" class="file-row pt-2 m-1 pb-2 d-none">
                    <!-- This is used as the file preview template -->
                    <div class="table-responsive">
                        <table class="table border mb-0">
                            <tbody>
                                <tr class="align-middle">
                                    <td>
                                        <div data-dz-name></div>
                                    </td>
                                    <td>
                                        <div class="clearfix">
                                            <div class="float-end">
                                                <small class="text-medium-emphasis" data-dz-size></small>
                                            </div>
                                        </div>
                                        <div class="progress progress-thin">
                                            <div class="progress-bar bg-success" data-dz-uploadprogress
                                                role="progressbar" style="width: 0%" aria-valuenow="0"
                                                aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                    <td style="width:200px">
                                        <input type="text" class="form-control form-control-sm w-auto" name="manual_entry_date" id="manual_entry_date" placeholder="yyyy-mm-dd">
                                    </td>
                                    <td style="width: 1%;white-space: nowrap;">
                                        <a class="btn btn-sm text-white btn-danger" data-dz-remove
                                            href="javascript:void(0);">Cancelar</a>
                                        <a class="btn btn-sm btn-primary start" href="javascript:void(0)">Cargar</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <p class="error text-danger fw-bold text-center" data-dz-errormessage></p>
                </div>
            </div>
        </form>
        <form action="{{ route('admin.external-balance.store') }}" method="post" class="" id="my-dropzone" enctype="multipart/form-data">
            @csrf
        </form>
    </div>
    <div class="col-md-12 mb-3">
        <div class="card shadow-lg">
            <div class="overlay d-none" wire:loading.class.remove="d-none"
                wire:target="previousPage, nextPage, gotoPage, search">
                <div class="spinner-grow" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
            {{-- <div class="card-header">
                <input class="form-control form-control-sm" type="text" wire:model.live.debounce.1500ms="search" placeholder="Buscar..">
            </div> --}}
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover table-sm small m-0">
                        <thead>
                            <tr>
                                <th style="width: 10px">ID</th>
                                <th class="text-center">Total<br>registros</th>
                                <th class="text-center">Total<br>registros 221</th>
                                <th class="text-center">Total<br>registros 222</th>
                                <th class="text-center">Total<br>proyectos</th>
                                <th class="text-center">Total<br>tipos de<br>materiales</th>
                                <th class="text-center">Total<br>BT</th>
                                <th class="text-center">Total<br>MT</th>
                                <th class="text-center">Total<br>TR</th>
                                <th class="text-center">Fecha manual<br>de registro</th>
                                <th class="text-center">
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($externalBalances as $externalBalance)
                                <tr class="align-middle">
                                    <td>{{ $externalBalance->id }}</td>
                                    <td class="text-center">{{ $externalBalance->total_records }}</td>
                                    <td class="text-center">{{ $externalBalance->total_records_221 }}</td>
                                    <td class="text-center">{{ $externalBalance->total_records_222 }}</td>
                                    <td class="text-center">{{ $externalBalance->total_projects }}</td>
                                    <td class="text-center">{{ $externalBalance->total_material_types }}</td>
                                    <td class="text-center">{{ $externalBalance->total_BT }}</td>
                                    <td class="text-center">{{ $externalBalance->total_MT }}</td>
                                    <td class="text-center">{{ $externalBalance->total_TR }}</td>
                                    <td class="stacked-info text-center">
                                        @if (isset($externalBalance->manual_entry_date))
                                            {{ $externalBalance->manual_entry_date->format('d-m-Y') }}<br>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item waves-effect" href="{{route('admin.external-balance.show', $externalBalance)}}">
                                                    <i class="ti ti-eye me-1"></i> Ver
                                                </a>
                                                  <a class="dropdown-item waves-effect" href="javascript:void(0);" 
                                                  {{-- wire:click="$dispatch('showModal','confirm-delete-modal', {{$externalBalance->id}},'App\\Models\\ExternalBalance')" --}}
                                                  wire:click="$dispatch('showModal', {data: {'alias' : 'confirm-delete-modal','size':'modal-sm','params' :{objectToDelete:{{ $externalBalance->id }}, model:'App\\Models\\ExternalBalance' }}})"
                                                  >
                                                    <i class="ti ti-trash me-1"></i> Eliminar
                                                </a>
                                            </div>
                                        </div>
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
        <div class="table-responsive">
            {{ $externalBalances->links() }}
        </div>
    </div>
@script
<script>
    $(function() {
        // upload documents
        var previewNode = document.querySelector("#template");
        previewNode.id = "";
        var previewTemplate = previewNode.parentNode.innerHTML;
        previewNode.parentNode.removeChild(previewNode);
        var buttonId;

        var myDropzone = new Dropzone(document.querySelector(
        "#my-dropzone"), { // Make the whole body a dropzone
            parallelUploads: 1,
            uploadMultiple: false,
            acceptedFiles: ".xls,.xlsx,.csv",
            maxFilesize: 8,
            previewTemplate: previewTemplate,
            autoQueue: false, // Make sure the files aren't queued until manually added
            previewsContainer: "#previews", // Define the container to display the previews
            clickable: ".fileinput-button", // Define the element that should be used as click trigger to select files.
            dictFileTooBig: 'Archivo demasiado grande. Maximo permitido 8MB',
        });

        myDropzone.on("addedfile", function(file) {
            // Hookup the start button
            $(file.previewElement).removeClass('d-none');
            file.previewElement.querySelector(".start").onclick = function() {
                myDropzone.enqueueFile(file);
            };
            $('.fileinput-button').addClass('d-none');
        });

        myDropzone.on("error", function(file, message) {
            $(file.previewElement).find('.start').addClass('disabled');
        });

        myDropzone.on('removedfile', function(file) {
            $('.fileinput-button').removeClass('d-none');
        });

        myDropzone.on("sending", function(file, xhr, formData) {
            //Disable the start button
            $(file.previewElement).find('.start').addClass('d-none');
            $(file.previewElement).find('[data-dz-remove]').addClass('d-none');

            var manualEntryDate = file.previewElement.querySelector("#manual_entry_date").value;
            formData.append("manual_entry_date", manualEntryDate);
            console.log('sending', file, xhr, formData);
        });

        myDropzone.on("processing", function(file, responseText) {
            console.log('processing', file, responseText);

        });

        myDropzone.on("complete", function(file, responseText) {
            // Hookup the start button
            console.log('complete', file, responseText);
            myDropzone.removeFile(file);
            // @this.refreshPost();

        });

        myDropzone.on("success", function(file, responseText) {
            window.location.reload();
            // console.log('success', file, responseText); // console should show the ID you pointed to
            // var totalRecords = responseText.totalRecords;
            // $("#total-records").text(totalRecords);

            // var totalProjects = responseText.totalProjects;
            // $("#total-projects").text(totalProjects);

            // var total221 = responseText.records221And222[221];
            // var percentage221 = (total221 * 100) / totalRecords;
            // $("#records-221").text(total221 + " (" + percentage221.toFixed(2) + "%)");

            // var total222 = responseText.records221And222[222];
            // var percentage222 = (total222 * 100) / totalRecords;
            // $("#records-222").text(total222 + " (" + percentage222.toFixed(2) + "%)");

            // var totalMaterials = responseText.totalMaterials;
            // $("#total-materials").text(totalMaterials);
        });
    });
</script>
@endscript
</div>
