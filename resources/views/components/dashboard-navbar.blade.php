<header class="header header-sticky mb-4 d-print-none">
    <div class="container-fluid">
        <button class="header-toggler px-md-0 me-md-3" type="button"
            onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()">
            <x-coreui-icon svgClass="icon icon-lg" icon="cil-menu"/>
        </button>
        <a class="header-brand d-md-none" href="#">
            <x-coreui-icon svgClass="icon icon-lg" icon="cil-menu" width="118" height="46"/>
        </a>
        <ul class="header-nav ms-auto d-none">
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <x-coreui-icon svgClass="icon icon-lg" icon="cil-bell"/>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <x-coreui-icon svgClass="icon icon-lg" icon="cil-list-rich"/>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <x-coreui-icon svgClass="icon icon-lg" icon="cil-envelope-open"/>
                </a>
            </li>
        </ul>
        <ul class="header-nav ms-3">
            <li class="nav-item dropdown"><a class="nav-link py-0" data-coreui-toggle="dropdown" href="#"
                    role="button" aria-haspopup="true" aria-expanded="false">
                    <div class="avatar avatar-md">
                        <img class="avatar-img" src="https://dummyimage.com/40x40/f0f0f0.jpg&text={{$abbreviature}}"
                            alt="user@email.com">
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end pt-0">
                    <form action="{{route('logout')}}" method="post">
                        @method('post')
                        @csrf
                        <button type="submit" class="dropdown-item">
                            <x-coreui-icon svgClass="icon me-2" icon="cil-account-logout"/>
                            Cerrar Sesion
                        </button>
                    </form>
                </div>
            </li>
        </ul>
    </div>
    <div class="header-divider"></div>
    <div class="container-fluid">
        @yield('breadcrumb')
        <nav class="d-none" aria-label="breadcrumb">
            <ol class="breadcrumb my-0 ms-2">
                <li class="breadcrumb-item">
                    <!-- if breadcrumb is single-->
                    <span>Home</span>
                </li>
                <li class="breadcrumb-item active"><span>Dashboard</span></li>
            </ol>
        </nav>
    </div>
</header>
