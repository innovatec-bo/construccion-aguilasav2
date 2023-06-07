<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class DashboardMenu extends Component
{
    public $menu;
    public $user;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->user = Auth::user();
        $this->buildMenu();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.dashboard-menu');
    }

    public function buildMenu()
    {
        $this->menu = [
            [
                'text'        => 'Inicio',
                'route'       => 'admin.home.index',
                'icon'        => 'cil-home',
            ],
            // [
            //     'text' => 'Dashboard',
            //     'route' => 'admin.home.dashboard',
            //     'icon' => 'cil-speedometer',
            // ],
            [
                'text'        => 'Proyectos',
                'icon'        => 'cil-folder',
                'can'         => ['admin.projects.index', 'admin.projects.create'],
                'submenu'     => [
                    [
                        'text'        => 'Lista',
                        'route'       => 'admin.projects.index',
                        'can'         => ['admin.projects.index'],
                        'icon'        => 'cil-speedometer',
                    ],
                    [
                        'text'        => 'Crear',
                        'route'       => 'admin.projects.create',
                        'can'         => ['admin.projects.create'],
                        'icon'        => 'cil-speedometer',
                    ],
                ]
            ],
            [
                'text'        => 'Manos de obra',
                'icon'        => 'cil-file',
                'can'         => ['admin.labor-details.index','admin.projects.rectify-manpower'],
                'submenu'     => [
                    [
                        'text'        => 'Lista',
                        'route'       => 'admin.labor-details.index',
                        'can'         => ['admin.labor-details.index'],
                        'icon'        => 'fas fa-fw fa-table',
                    ],
                    [
                        'text'        => 'Rectificar Mano de obra',
                        'route'       => 'admin.projects.rectify-manpower',
                        'can'         => ['admin.projects.rectify-manpower'],
                        'icon'        => 'fas fa-fw fa-edit',
                    ]
                ]
            ],
            [
                'text'        => 'Almacen',
                'icon'        => 'cil-house',
                'can'         => ['admin.materials-summary.index','admin.materials-summary.load-initial-list','admin.builder-debts-report.index','admin.materials.material-summary'],
                'submenu'     => [
                    [
                        'text'        => 'Movimientos',
                        'route'       => 'admin.materials-summary.index',
                        'can'         => ['admin.materials-summary.index'],
                        'icon'        => 'fas fa-fw fa-file-alt',
                    ],
                    [
                        'text'        => 'Movimientos agrupados',
                        'route'       => 'admin.materials-summary.grouped-movements',
                        // 'can'         => 'admin.materials-summary.index',
                        'icon'        => 'fas fa-fw fa-file-alt',
                    ],
                    [
                        'text'        => 'Cargar lista inicial',
                        'route'       => 'admin.materials-summary.load-initial-list',
                        'can'         => ['admin.materials-summary.load-initial-list'],
                        'icon'        => 'fas fa-fw fa-file-upload',
                    ],
                    [
                        'text'        => 'Constructores y deudas',
                        'route'       => 'admin.builder-debts-report.index',
                        'can'         => ['admin.builder-debts-report.index'],
                        'icon'        => 'fas fa-fw fa-book-open',
                    ],
                    [
                        'text'        => 'Salidas observadas',
                        'route'       => 'admin.materials-summary.duplicate-outputs',
                        'can'         => ['admin.materials-summary.duplicate-outputs'],
                        'icon'        => 'fas fa-fw fa-exclamation-triangle',
                    ],
                    [
                        'text'        => 'Resumen de materiales',
                        'route'       => 'admin.materials.material-summary',
                        'can'         => ['admin.materials.material-summary'],
                        'icon'        => 'fas fa-fw fa-table',
                    ],
                    [
                        'text'        => 'Depurar materiales',
                        'route'       => 'admin.materials.debug-pending-in-cre',
                        'can'         => ['admin.materials.debug-pending-in-cre'],
                        'icon'        => 'fas fa-fw fa-bug',
                    ],
                    [
                        'text'        => 'Balance externo de materiales',
                        'route'       => 'admin.external-balance-material.index',
                        'can'         => ['admin.external-balance-material.index'],
                        'icon'        => 'fas fa-fw fa-table',
                    ],
                    
                ],  
            ],
            [
                'text'        => 'Estructuras',
                'icon'        => 'cil-layers',
                'can'         => ['admin.building-structures.index','admin.building-structures.upload-default-materials'],
                'submenu'     => [
                    [
                        'text'        => 'Lista',
                        'route'       => 'admin.building-structures.index',
                        'can'         => 'admin.building-structures.index',
                        'icon'        => 'fas fa-fw fa-table',
                    ],
                    [
                        'text'        => 'Establecer materiales',
                        'route'       => 'admin.building-structures.upload-default-materials',
                        'can'         => 'admin.building-structures.upload-default-materials',
                        'icon'        => 'fas fa-fw fa-cogs',
                    ]
                ]
            ],
            [
                'text'        => 'Materiales',
                'icon'        => 'cil-puzzle',
                'can'         => ['admin.materials.index', 'admin.materials.create'],
                'submenu'     => [
                    [
                        'text'        => 'Lista',
                        'route'       => 'admin.materials.index',
                        'can'         => 'admin.materials.index',
                        'icon'        => 'fas fa-fw fa-table',
                    ],
                    [
                        'text'        => 'Crear',
                        'route'       => 'admin.materials.create',
                        'can'         => 'admin.materials.create',
                        'icon'        => 'fas fa-fw fa-plus',
                    ],
                ]
            ],
            [
                'text'        => 'Observaciones externas',
                'icon'        => 'cil-notes',
                'can'         => ['admin.external-observations.index', 'admin.external-observations.create'],
                'submenu'     => [
                    [
                        'text'        => 'Lista',
                        'route'       => 'admin.external-observations.index',
                        'can'         => 'admin.external-observations.index',
                        'icon'        => 'fas fa-fw fa-table',
                    ],
                    [
                        'text'        => 'Crear',
                        'route'       => 'admin.external-observations.create',
                        'can'         => 'admin.external-observations.create',
                        'icon'        => 'fas fa-fw fa-plus',
                    ]
                ]
            ],
            ['header' => 'SEGURIDAD', 'can' => ['admin.users.index', 'admin.users.create', 'admin.permissions.index', 'admin.permissions.create','admin.roles.index', 'admin.roles.create']],
            [
                'text'        => 'Usuarios',
                'icon'        => 'cil-group',
                'can'         => ['admin.users.index', 'admin.users.create'],
                'submenu'     => [
                    [
                        'text'        => 'Lista',
                        'can'         => 'admin.users.index',
                        'route'       => 'admin.users.index',
                        'icon'        => 'fas fa-fw fa-table',
                    ],
                    [
                        'text'        => 'Crear',
                        'can'         => 'admin.users.create',
                        'route'       => 'admin.users.create',
                        'icon'        => 'fas fa-fw fa-plus',
                    ]       
                ]
            ],
            [
                'text'        => 'Permisos',
                'icon'        => 'cil-lock-locked',
                'can'         => ['admin.permissions.index', 'admin.permissions.create'],
                'submenu'     => [
                    [
                        'text'        => 'Lista',
                        'route'       => 'admin.permissions.index',
                        'can'         => 'admin.permissions.index',
                        'icon'        => 'fas fa-fw fa-table',
                    ],
                    [
                        'text'        => 'Crear',
                        'route'       => 'admin.permissions.create',
                        'can'         => 'admin.permissions.create',
                        'icon'        => 'fas fa-fw fa-plus',
                    ]       
                ]
            ],
            [
                'text'        => 'Roles',
                'icon'        => 'cil-shield-alt',
                'can'         => ['admin.roles.index', 'admin.roles.create'],
                'submenu'     => [
                    [
                        'text'        => 'Lista',
                        'route'       => 'admin.roles.index',
                        'can'         => 'admin.roles.index',
                        'icon'        => 'fas fa-fw fa-table',
                    ],
                    [
                        'text'        => 'Crear',
                        'route'       => 'admin.roles.create',
                        'can'         => 'admin.roles.create',
                        'icon'        => 'fas fa-fw fa-plus',
                    ]       
                ]
            ],
            // [
            //     'text'        => 'Documentacion',
            //     'icon'        => 'fas fa-fw fa-book',
            //     'url'         => 'docs'
            // ],
        ];

        $this->validatePermission();
    }

    public function validatePermission()
    {
        if (!$this->user->hasRole('Super admin')) 
        {
            foreach ($this->menu as $key => $value) 
            {
                if (isset($value['can'])) 
                {
                    if (!$this->user->hasAnyPermission($value['can'])) 
                    {
                        unset($this->menu[$key]);
                    }
                }
                if (isset($value['submenu'])) 
                {
                    foreach ($value['submenu'] as $subKey => $subMenu) 
                    {
                        if (isset($subMenu['can'])) 
                        {
                            if (!$this->user->hasAnyPermission($subMenu['can'])) 
                            {
                                unset($subMenu[$subKey]);
                            }
                        }
                    }
                }
            }
        }
    }
}
