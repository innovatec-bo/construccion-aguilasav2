<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card shadow-lg">
            {{-- <div class="card-header">

            </div> --}}
            <div class="card-body">
                {{-- <h5 class="card-title">Special title treatment</h5> --}}
                <p class="card-text">El balance externo de materiales contiene un resumen de los materiales que ya se han
                    devuelto y que aun deben devolverse a CRE</p>
                {{-- <p class="card-text">La importacion del archivo excel consta de 3 pasos:</p> --}}
                {{-- <ol>
                    <li>Cuando se selecciona el archivo, este es leido por el sistema y arroja un breve detalle, sobre
                        el nombre y el peso del mismo</li>
                    <li>Cuando el achivo es seleccionado, aparece un boton llamado "Pre cargar", que nos da un detalle
                        mas amplio esta ves acerca de la informacion contenida en el archivo</li>
                    <li>Si la informacion observada con el boton "Pre cargar" es satisfactoria, entonces procedemos a
                        cargar el archivo. Nota: debido a que el archivo es bastante pesado, no se almacena en el
                        servidor.</li>
                </ol> --}}
                <p class="text-center">
                    <a class="btn btn-primary fileinput-button" href="javascript:void(0);">Cargar Balance externo de materiales</a>
                    {{-- <a class="btn btn-primary start" href="javascript:void(0);">Cargar</a> --}}
                </p>
                <form id="form-previews" class="my-4" data-parsley-validate='' wire:ignore>
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
                                                    <div class="progress-bar bg-success" data-dz-uploadprogress role="progressbar" style="width: 0%"
                                                        aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </td>
                                            <td>
                                                <a class="btn btn-danger" data-dz-remove href="javascript:void(0);">Cancelar</a>
                                                <a class="btn btn-primary start" href="javascript:void(0)">Cargar</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <p class="error text-danger fw-bold text-center" data-dz-errormessage></p>
                        </div>
                    </div>
                </form>
                {!! Form::open(['route' => ['admin.external-balance-material.store'],'method' => 'post','class'=>'','id'=>'my-dropzone','enctype' => 'multipart/form-data']) !!}
                {!! Form::close() !!}
            </div>
            <div class="card-footer">
                <div class="row row-cols-1 row-cols-md-5 text-center">
                    <div class="col mb-sm-2 mb-0">
                        <div class="text-medium-emphasis">Proyectos</div>
                        <div class="fw-semibold" id="total-projects"></div>
                    </div>
                    <div class="col mb-sm-2 mb-0">
                        <div class="text-medium-emphasis">Registros 221</div>
                        <div class="fw-semibold" id="records-221"></div>
                    </div>
                    <div class="col mb-sm-2 mb-0">
                        <div class="text-medium-emphasis">Registros 222</div>
                        <div class="fw-semibold" id="records-222"></div>
                    </div>
                    <div class="col mb-sm-2 mb-0">
                        <div class="text-medium-emphasis">Tipos de Materiales</div>
                        <div class="fw-semibold" id="total-materials"></div>
                    </div>
                    <div class="col mb-sm-2 mb-0">
                        <div class="text-medium-emphasis">Total registros</div>
                        <div class="fw-semibold" id="total-records"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        $(function() {
            // upload documents
            var previewNode = document.querySelector("#template");
            previewNode.id = "";
            var previewTemplate = previewNode.parentNode.innerHTML;
            previewNode.parentNode.removeChild(previewNode);
            var buttonId;
            
            var myDropzone = new Dropzone(document.querySelector("#my-dropzone"), { // Make the whole body a dropzone
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
                file.previewElement.querySelector(".start").onclick = function() { myDropzone.enqueueFile(file); };
                $('.fileinput-button').addClass('d-none');
            });

            myDropzone.on("error", function(file, message) {
                $(file.previewElement).find('.start').addClass('disabled');
            });

            myDropzone.on('removedfile', function(file){
                $('.fileinput-button').removeClass('d-none');
            });

            myDropzone.on("sending", function(file, xhr, formData) {
                //Disable the start button
                $(file.previewElement).find('.start').addClass('d-none');
                $(file.previewElement).find('[data-dz-remove]').addClass('disabled');
                console.log('sending',file, xhr, formData);
            });

            myDropzone.on("processing", function(file,responseText) {
                console.log('processing',file,responseText);
                
            });

            myDropzone.on("complete", function(file,responseText) {
                // Hookup the start button
                console.log('complete',file,responseText);
                myDropzone.removeFile(file);
                // @this.refreshPost();
                
            });

            myDropzone.on("success", function(file, responseText) {
                // var responseText = file // or however you would point to your assigned file ID here;
                console.log('success',file,responseText); // console should show the ID you pointed to
                var totalRecords = responseText.totalRecords;
                $("#total-records").text(totalRecords);

                var totalProjects = responseText.totalProjects;
                $("#total-projects").text(totalProjects);
                
                var total221 = responseText.records221And222[221];
                var percentage221 = (total221 * 100) / totalRecords;
                $("#records-221").text(total221+" ("+percentage221.toFixed(2)+"%)");
                
                var total222 = responseText.records221And222[222];
                var percentage222 = (total222 * 100) / totalRecords;
                $("#records-222").text(total222+" ("+percentage222.toFixed(2)+"%)");

                var totalMaterials = responseText.totalMaterials;
                $("#total-materials").text(totalMaterials);
                // do stuff with file.id ...
            });
        });
    </script>
    @endpush
</div>