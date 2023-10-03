@extends('layouts.dashboard-layout')

@section('title', 'Rectificar mano de obra')

@section('breadcrumb')
    {{ Breadcrumbs::render('admin.projects.rectify-manpower') }}
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-body">
                    {{-- <form method="post" action="">
                    @csrf
                    @method('post')
                    <div class="card-body">

                        <div class="form-group mb-3">
                            <label for="exampleInputFile">File input</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="exampleInputFile">
                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text">Upload</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputFile">COD. proyecto</label>
                            <div class="input-group">
                                <input type="text" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form> --}}
                    <p class="text-center">
                        <a class="btn btn-primary fileinput-button" href="javascript:void(0);">Cargar Mano de obra</a>
                    </p>
                    {{-- <form id="form-previews" class="my-4" data-parsley-validate='' wire:ignore>
                    <div class="files" id="previews">
                        <div id="template" class="file-row pt-2 m-1 pb-2 d-none">
                            <!-- This is used as the file preview template -->
                            <div class="table-responsive" style="background: #e8e8e8;">
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
                                            <td>
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
                </form> --}}
                    <form id="form-previews" class="my-4" data-parsley-validate=''>
                        <div class="files" id="previews">
                            <div id="template" class="file-row pt-2 m-1 pb-2 d-none">
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <div class="d-flex justify-content-between">
                                            <div class="float-start">
                                                <div class="fw-semibold" data-dz-name></div>
                                            </div>
                                            <div class="float-end ms-1 text-nowrap"><small class="text-medium-emphasis" data-dz-size></small></div>
                                        </div>
                                        <div class="progress progress-thin">
                                            <div class="progress-bar bg-success-gradient" data-dz-uploadprogress role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label" for="inputEmail3">Proyecto</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" id="inputEmail3" type="email">
                                    </div>
                                </div>
                                <fieldset class="row mb-3">
                                    <legend class="col-form-label col-sm-2 pt-0">Acci&oacute;n</legend>
                                    <div class="col-sm-10">
                                        <div class="form-check">
                                            <input class="form-check-input" id="gridRadios1" type="radio"
                                                name="gridRadios" value="option1" checked="">
                                            <label class="form-check-label" for="gridRadios1">Actualizar precios, no borrar
                                                nada.</label>
                                        </div>
                                        <div class="form-check disabled">
                                            <input class="form-check-input" id="gridRadios3" type="radio"
                                                name="gridRadios" value="option3" disabled="">
                                            <label class="form-check-label" for="gridRadios3">Eliminar mano de obra
                                                existente y reemplazar con la que se esta cargando.</label>
                                        </div>
                                    </div>
                                </fieldset>
                                <button class="btn btn-primary" type="submit">Sign in</button>
                            </div>
                        </div>
                    </form>
                    {!! Form::open([
                        'route' => ['admin.external-balance.store'],
                        'method' => 'post',
                        'class' => '',
                        'id' => 'my-dropzone',
                        'enctype' => 'multipart/form-data',
                    ]) !!}
                    {!! Form::close() !!}
                </div>

            </div>
        </div>
    </div>

@stop

@section('css')
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
@stop

@section('js')
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
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
                console.log('sending', file, xhr, formData);
            });

            myDropzone.on("processing", function(file, responseText) {
                console.log('processing', file, responseText);

            });

            myDropzone.on("complete", function(file, responseText) {
                // Hookup the start button
                console.log('complete', file, responseText);
                myDropzone.removeFile(file);

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
@stop
