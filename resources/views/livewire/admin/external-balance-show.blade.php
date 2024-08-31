<div class="row justify-content-center">
    <div class="overlay d-none" wire:loading.class.remove="d-none" wire:target="previousPage, nextPage, gotoPage, search">
        <div class="spinner-grow" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
    </div>
    <div class="col-md-12 mb-3">
        <div class="row">
            <div class="col-md-3">
                <input class="form-control form-control-sm" type="text" wire:model.live.debounce.1500ms="search" placeholder="Codigo de proyecto">
            </div>
        </div>
    </div>
    <div class="col-md-12 mb-3">
        <div class="card shadow-lg">
            
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover m-0 table-sm small">
                        <thead>
                            <tr>
                                <th style="width: 10px">ID</th>
                                <th>ElementoPEP</th>
                                <th>Proyecto</th>
                                <th>Material</th>
                                <th>Texto_breve_de_material</th>
                                <th>Alm</th>
                                <th>Cantidad</th>
                                <th>Lote</th>
                                <th>CMv</th>
                                <th>Docmat</th>
                                <th>Reserva</th>
                                <th>Textocabdocumento</th>
                                <th>Referencia</th>
                                <th>Fecontab</th>
                                <th>fechadoc</th>
                                <th>Registrado</th>
                                <th>EjMat</th>
                                <th>Cecoste</th>
                                <th>Grafo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($externalBalanceMaterials as $externalBalanceMaterial)
                                <tr>
                                    <td>{{$externalBalanceMaterial->id}}</td>
                                    <td>{{$externalBalanceMaterial->ElementoPEP}}</td>
                                    <td>{{$externalBalanceMaterial->Proyecto}}</td>
                                    <td>{{$externalBalanceMaterial->Material}}</td>
                                    <td>{{$externalBalanceMaterial->Texto_breve_de_material}}</td>
                                    <td>{{$externalBalanceMaterial->Alm}}</td>
                                    <td>{{$externalBalanceMaterial->Cantidad}}</td>
                                    <td>{{$externalBalanceMaterial->Lote}}</td>
                                    <td>{{$externalBalanceMaterial->CMv}}</td>
                                    <td>{{$externalBalanceMaterial->Docmat}}</td>
                                    <td>{{$externalBalanceMaterial->Reserva}}</td>
                                    <td>{{$externalBalanceMaterial->Textocabdocumento}}</td>
                                    <td>{{$externalBalanceMaterial->Referencia}}</td>
                                    <td>{{$externalBalanceMaterial->Fecontab}}</td>
                                    <td>{{$externalBalanceMaterial->Fechadoc}}</td>
                                    <td>{{$externalBalanceMaterial->Registrado}}</td>
                                    <td>{{$externalBalanceMaterial->EjMat}}</td>
                                    <td>{{$externalBalanceMaterial->Cecoste}}</td>
                                    <td>{{$externalBalanceMaterial->Grafo}}</td>
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
            {{ $externalBalanceMaterials->links() }}
        </div>
    </div>
</div>