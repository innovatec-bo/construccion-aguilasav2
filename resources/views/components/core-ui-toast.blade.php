<div>
    <div class="toast-container position-fixed top-0 end-0 p-3">
        <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <svg class="docs-placeholder-img rounded me-2" width="20" height="20">
                    <use xlink:href="{{asset('coreui/vendors/@coreui/icons/svg/free.svg#')}}cil-info"></use>
                </svg>
                <strong class="me-auto">Success</strong>
                <small>11 mins ago</small>
                <button type="button" class="btn-close" data-coreui-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                {{ session('successMessage') }}
            </div>
        </div>
    </div>
    
    <script>
        const toastLive = document.getElementById('liveToast');
        const toastCoreUI = coreui.Toast.getOrCreateInstance(toastLive);
        
        @if (session('successMessage'))
            // window.toastr.success("{{ session('successMessage') }}");
            // {{<x-core-ui-toast-notification/>}}
            
            @php
        
            @endphp        
            toastCoreUI.show();
        @endif
        @if (session('errorMessage'))
            // window.toastr.error("{{ session('errorMessage') }}");
            toastCoreUI.show();
            console.log('toc toc1');
        @endif
        @if (session('infoMessage'))
            // window.toastr.info("{{ session('infoMessage') }}");
            toastCoreUI.show();
            console.log('toc toc2');
        @endif
        @if (session('warningMessage'))
            // window.toastr.warning( decodeHtml("{{ session('warningMessage') }}") );
            toastCoreUI.show();
            console.log('toc toc3');
        @endif
        // toastCoreUI.show();
        // console.log('toc toc', "{{ session('successMessage') }}");
        //Trigger from livewire
        document.addEventListener('DOMContentLoaded', function() {
            window.addEventListener('alert', event => {
                let type = event.detail[0];
                let message = event.detail[1];
                switch (event.detail[0]) {
                    case 'successMessage':
                        window.toastr.success(message);
                        break;
                    case 'errorMessage':
                        window.toastr.error(message);
                        break;
                    case 'infoMessage':
                        window.toastr.info(message);
                        break;
                    case 'warningMessage':
                        window.toastr.warning(message);
                        break;
                }
            });
        });
    </script>
</div>
