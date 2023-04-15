<div class="sidebar sidebar-dark sidebar-fixed" id="sidebar">
    <div class="sidebar-brand d-none d-md-flex">
        <img class="sidebar-brand-full" src="{{asset('images/logo.png')}}" width="190" alt="Serebo Logo">
        <img class="sidebar-brand-narrow" src="{{asset('images/favicon.png')}}" width="46" alt="Serebo Logo">
    </div>
    <ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
        @foreach ($menu as $item)
            <x-menu-item :item="$item"/>
        @endforeach
    </ul>
    <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
</div>
