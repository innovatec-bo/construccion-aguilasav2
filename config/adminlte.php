<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    | For detailed instructions you can look the title section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'title' => 'Serebo 2',
    'title_prefix' => '',
    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | Here you can activate the favicon.
    |
    | For detailed instructions you can look the favicon section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_ico_only' => false,
    'use_full_favicon' => false,

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For detailed instructions you can look the logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'logo' => '<b>SEREBO</b>2',
    // 'logo_img' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
    'logo_img' => 'favicon.ico',
    'logo_img_class' => 'brand-image img-circle elevation-3',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'SEREBO 2',

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    |
    | Here you can activate and change the user menu.
    |
    | For detailed instructions you can look the user menu section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'usermenu_enabled' => true,
    'usermenu_header' => false,
    'usermenu_header_class' => 'bg-primary',
    'usermenu_image' => false,
    'usermenu_desc' => false,
    'usermenu_profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here we change the layout of your admin panel.
    |
    | For detailed instructions you can look the layout section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => null,
    'layout_fixed_navbar' => null,
    'layout_fixed_footer' => null,
    'layout_dark_mode' => true,

    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the authentication views.
    |
    | For detailed instructions you can look the auth classes section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_auth_card' => 'card-outline card-primary',
    'classes_auth_header' => '',
    'classes_auth_body' => '',
    'classes_auth_footer' => '',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-primary',

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For detailed instructions you can look the admin panel classes here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_body' => 'dark-mode',
    'classes_brand' => '',
    'classes_brand_text' => '',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-dark-primary elevation-4',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-dark',
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container',

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar of the admin panel.
    |
    | For detailed instructions you can look the sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'sidebar_mini' => 'lg',
    'sidebar_collapse' => false,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we can modify the right sidebar aka control sidebar of the admin panel.
    |
    | For detailed instructions you can look the right sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Here we can modify the url settings of the admin panel.
    |
    | For detailed instructions you can look the urls section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_route_url' => false,
    'dashboard_url' => 'admin/inicio',
    'logout_url' => 'logout',
    'login_url' => 'login',
    'register_url' => false,
    'password_reset_url' => 'password/reset',
    'password_email_url' => 'password/email',
    'profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Laravel Mix
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Mix option for the admin panel.
    |
    | For detailed instructions you can look the laravel mix section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'enabled_laravel_mix' => true,
    'laravel_mix_css_path' => 'css/app.css',
    'laravel_mix_js_path' => 'js/app.js',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar/top navigation of the admin panel.
    |
    | For detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'menu' => [
        // Navbar items:
        // [
        //     'type'         => 'navbar-search',
        //     'text'         => 'search',
        //     'topnav_right' => true,
        // ],
        [
            'type'         => 'fullscreen-widget',
            'topnav_right' => true,
        ],

        // Sidebar items:
        [
            'type' => 'sidebar-menu-search',
            'text' => 'Buscar menu',
        ],
        [
            'text'        => 'Inicio',
            'route'       => 'admin.home.index',
            'icon'        => 'fas fa-fw fa-home',
        ],
        [
            'text'        => 'Proyectos',
            'icon'        => 'fas fa-fw fa-folder',
            'can'         => ['admin.projects.index', 'admin.projects.create'],
            'submenu'     => [
                [
                    'text'        => 'Lista',
                    'route'       => 'admin.projects.index',
                    'can'         => 'admin.projects.index',
                    'icon'        => 'fas fa-fw fa-table',
                    'shift' => 'pl-4',
                ],
                [
                    'text'        => 'Crear',
                    'route'       => 'admin.projects.create',
                    'can'         => 'admin.projects.create',
                    'icon'        => 'fas fa-fw fa-plus',
                    'shift' => 'pl-4',
                ]
            ]
        ],
        [
            'text'        => 'Manos de obra',
            'icon'        => 'fas fa-fw fa-tools',
            'can'         => ['admin.labor-details.index','admin.projects.rectify-manpower'],
            'submenu'     => [
                [
                    'text'        => 'Lista',
                    'route'       => 'admin.labor-details.index',
                    'can'         => 'admin.labor-details.index',
                    'icon'        => 'fas fa-fw fa-table',
                    'shift' => 'pl-4',
                ],
                [
                    'text'        => 'Rectificar Mano de obra',
                    'route'       => 'admin.projects.rectify-manpower',
                    'can'         => 'admin.projects.rectify-manpower',
                    'icon'        => 'fas fa-fw fa-edit',
                    'shift' => 'pl-4',
                ]
            ]
        ],
        [
            'text'        => 'Almacen',
            'icon'        => 'fas fa-fw fa-warehouse',
            'can'         => ['admin.materials-summary.index','admin.materials-summary.load-initial-list','admin.builder-debts-report.index','admin.materials.material-summary'],
            'submenu'     => [
                [
                    'text'        => 'Movimientos',
                    'route'       => 'admin.materials-summary.index',
                    'can'         => 'admin.materials-summary.index',
                    'icon'        => 'fas fa-fw fa-file-alt',
                    'shift' => 'pl-4',
                ],
                [
                    'text'        => 'Movimientos agrupados',
                    'route'       => 'admin.materials-summary.grouped-movements',
                    // 'can'         => 'admin.materials-summary.index',
                    'icon'        => 'fas fa-fw fa-file-alt',
                    'shift' => 'pl-4',
                ],
                [
                    'text'        => 'Cargar lista inicial',
                    'route'       => 'admin.materials-summary.load-initial-list',
                    'can'         => 'admin.materials-summary.load-initial-list',
                    'icon'        => 'fas fa-fw fa-file-upload',
                    'shift' => 'pl-4',
                ],
                [
                    'text'        => 'Constructores y deudas',
                    'route'       => 'admin.builder-debts-report.index',
                    'can'         => 'admin.builder-debts-report.index',
                    'icon'        => 'fas fa-fw fa-book-open',
                    'shift' => 'pl-4',
                ],
                [
                    'text'        => 'Salidas observadas',
                    'route'       => 'admin.materials-summary.duplicate-outputs',
                    'can'         => 'admin.materials-summary.duplicate-outputs',
                    'icon'        => 'fas fa-fw fa-exclamation-triangle',
                    'shift' => 'pl-4',
                ],
                [
                    'text'        => 'Depurar materiales',
                    // 'route'       => 'admin.materials.debug',
                    // 'can'         => 'admin.materials.debug',
                    'icon'        => 'fas fa-fw fa-bug',
                    'shift' => 'pl-4',
                ],
                [
                    'text'        => 'Resumen de materiales',
                    'route'       => 'admin.materials.material-summary',
                    'can'         => 'admin.materials.material-summary',
                    'icon'        => 'fas fa-fw fa-table',
                    'shift' => 'pl-4',
                ],
                [
                    'text'        => 'Registro 221 - 222',
                    'route'       => 'admin.materials.material-summary',
                    'can'         => 'admin.materials.material-summary',
                    'icon'        => 'fas fa-fw fa-table',
                    'shift' => 'pl-4',
                ],
                
            ],  
        ],
        [
            'text'        => 'Estructuras',
            'icon'        => 'fas fa-fw fa-shapes',
            'can'         => ['admin.building-structures.index','admin.building-structures.upload-default-materials'],
            'submenu'     => [
                [
                    'text'        => 'Lista',
                    'route'       => 'admin.building-structures.index',
                    'can'         => 'admin.building-structures.index',
                    'icon'        => 'fas fa-fw fa-table',
                    'shift' => 'pl-4',
                ],
                [
                    'text'        => 'Establecer materiales',
                    'route'       => 'admin.building-structures.upload-default-materials',
                    'can'         => 'admin.building-structures.upload-default-materials',
                    'icon'        => 'fas fa-fw fa-cogs',
                    'shift' => 'pl-4',
                ]
            ]
        ],
        [
            'text'        => 'Materiales',
            'icon'        => 'fas fa-fw fa-shapes',
            'can'         => ['admin.materials.index', 'admin.materials.create'],
            'submenu'     => [
                [
                    'text'        => 'Lista',
                    'route'       => 'admin.materials.index',
                    'can'         => 'admin.materials.index',
                    'icon'        => 'fas fa-fw fa-table',
                    'shift' => 'pl-4',
                ],
                [
                    'text'        => 'Crear',
                    'route'       => 'admin.materials.create',
                    'can'         => 'admin.materials.create',
                    'icon'        => 'fas fa-fw fa-plus',
                    'shift' => 'pl-4',
                ],
            ]
        ],
        [
            'text'        => 'Observaciones externas',
            'icon'        => 'fas fa-fw fa-shapes',
            'can'         => ['admin.external-observations.index', 'admin.external-observations.create'],
            'submenu'     => [
                [
                    'text'        => 'Lista',
                    'route'       => 'admin.external-observations.index',
                    'can'         => 'admin.external-observations.index',
                    'icon'        => 'fas fa-fw fa-table',
                    'shift' => 'pl-4',
                ],
                [
                    'text'        => 'Crear',
                    'route'       => 'admin.external-observations.create',
                    'can'         => 'admin.external-observations.create',
                    'icon'        => 'fas fa-fw fa-plus',
                    'shift' => 'pl-4',
                ]
            ]
        ],
        ['header' => 'SEGURIDAD', 'can' => ['admin.users.index', 'admin.users.create', 'admin.permissions.index', 'admin.permissions.create','admin.roles.index', 'admin.roles.create']],
        [
            'text'        => 'Usuarios',
            'icon'        => 'fas fa-fw fa-users',
            'can'         => ['admin.users.index', 'admin.users.create'],
            'submenu'     => [
                [
                    'text'        => 'Lista',
                    'can'         => 'admin.users.index',
                    'route'       => 'admin.users.index',
                    'icon'        => 'fas fa-fw fa-table',
                    'shift' => 'pl-4',
                ],
                [
                    'text'        => 'Crear',
                    'can'         => 'admin.users.create',
                    'route'       => 'admin.users.create',
                    'icon'        => 'fas fa-fw fa-plus',
                    'shift' => 'pl-4',
                ]       
            ]
        ],
        [
            'text'        => 'Permisos',
            'icon'        => 'fas fa-fw fa-user-shield',
            'can'         => ['admin.permissions.index', 'admin.permissions.create'],
            'submenu'     => [
                [
                    'text'        => 'Lista',
                    'route'       => 'admin.permissions.index',
                    'can'         => 'admin.permissions.index',
                    'icon'        => 'fas fa-fw fa-table',
                    'shift' => 'pl-4',
                ],
                [
                    'text'        => 'Crear',
                    'route'       => 'admin.permissions.create',
                    'can'         => 'admin.permissions.create',
                    'icon'        => 'fas fa-fw fa-plus',
                    'shift' => 'pl-4',
                ]       
            ]
        ],
        [
            'text'        => 'Roles',
            'icon'        => 'fas fa-fw fa-id-card',
            'can'         => ['admin.roles.index', 'admin.roles.create'],
            'submenu'     => [
                [
                    'text'        => 'Lista',
                    'route'       => 'admin.roles.index',
                    'can'         => 'admin.roles.index',
                    'icon'        => 'fas fa-fw fa-table',
                    'shift' => 'pl-4',
                ],
                [
                    'text'        => 'Crear',
                    'route'       => 'admin.roles.create',
                    'can'         => 'admin.roles.create',
                    'icon'        => 'fas fa-fw fa-plus',
                    'shift' => 'pl-4',
                ]       
            ]
        ],
        [
            'text'        => 'Documentacion',
            'icon'        => 'fas fa-fw fa-book',
            'url'         => 'docs'
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For detailed instructions you can look the menu filters section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Here we can modify the plugins used inside the admin panel.
    |
    | For detailed instructions you can look the plugins section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Plugins-Configuration
    |
    */

    'plugins' => [
        'Datatables' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css',
                ],
            ],
        ],
        'Select2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css',
                ],
            ],
        ],
        'Chartjs' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/sweetalert2/sweetalert2.all.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css',
                ]
            ],
        ],
        'Pace' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                ],
            ],
        ],
        'toastr' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/toastr/toastr.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/toastr/toastr.min.js',
                ],
            ],
        ],
        'bsCustomFileInput' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/bs-custom-file-input/bs-custom-file-input.min.js',
                ]
            ],
        ],
        'inputmask' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/inputmask/jquery.inputmask.min.js',
                ],
            ],
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | IFrame
    |--------------------------------------------------------------------------
    |
    | Here we change the IFrame mode configuration. Note these changes will
    | only apply to the view that extends and enable the IFrame mode.
    |
    | For detailed instructions you can look the iframe mode section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/IFrame-Mode-Configuration
    |
    */

    'iframe' => [
        'default_tab' => [
            'url' => null,
            'title' => null,
        ],
        'buttons' => [
            'close' => true,
            'close_all' => true,
            'close_all_other' => true,
            'scroll_left' => true,
            'scroll_right' => true,
            'fullscreen' => true,
        ],
        'options' => [
            'loading_screen' => 1000,
            'auto_show_new_tab' => true,
            'use_navbar_items' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Livewire
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Livewire support.
    |
    | For detailed instructions you can look the livewire here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'livewire' => true,
];
