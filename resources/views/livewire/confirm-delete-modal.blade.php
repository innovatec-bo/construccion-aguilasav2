<div class="modal-dialog modal-dialog-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Eliminar?</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        {{-- <div class="modal-body">
            
        </div> --}}
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-danger text-white" wire:click="delete">Si, eliminar</button>
        </div>
    </div>
    {{-- <script>
        $(function() {

            $('.input-group.date').datepicker({
                language: "es",
                format: 'dd-mm-yyyy',
                autoclose: true,
            });

            $('.input-group.date').on('changeDate', function(e) {
                let date = null;
                if (e.date !== undefined) 
                {
                    date = moment(e.date).format('DD/MM/YYYY');
                }
                if ($(this).hasClass('from')) 
                {
                    window.livewire.emit('fromChanged', date); 
                    console.log(date);
                } 
                else 
                {
                    window.livewire.emit('toChanged', date);
                }
            });
        });
    </script> --}}
</div>
