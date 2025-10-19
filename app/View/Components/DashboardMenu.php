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
                'icon'        => 'ti ti-smart-home',
            ],
            // [
            //     'text' => 'Dashboard',
            //     'route' => 'admin.home.dashboard',
            //     'icon' => 'cil-speedometer',
            // ],
            [
                'text'        => 'Proyectos',
                'icon'        => 'ti ti-folder',
                'can'         => ['admin.projects.index', 'admin.projects.create'],
                'submenu'     => [
                    [
                        'text'        => 'Lista',
                        'route'       => 'admin.projects.index',
                        'can'         => ['admin.projects.index'],
                        'icon'        => '',
                    ],
                    [
                        'text'        => 'Crear',
                        'route'       => 'admin.projects.create',
                        'can'         => ['admin.projects.create'],
                        'icon'        => '',
                    ],
                ]
            ],
            [
                'text'        => 'Manos de obra',
                'icon'        => 'ti ti-file',
                'can'         => ['admin.labor-details.index','admin.projects.rectify-manpower'],
                'submenu'     => [
                    [
                        'text'        => 'Lista',
                        'route'       => 'admin.labor-details.index',
                        'can'         => ['admin.labor-details.index'],
                        'icon'        => '',
                    ],
                    [
                        'text'        => 'Rectificar Mano de obra',
                        'route'       => 'admin.projects.rectify-manpower',
                        'can'         => ['admin.projects.rectify-manpower'],
                        'icon'        => '',
                    ],
                    [
                        'text'        => 'Registro de avance',
                        'route'       => 'admin.labor-cost-log.index',
                        // 'can'         => ['admin.labor-cost-log.index'],
                        'icon'        => '',
                    ],
                ]
            ],
            [
                'text'        => 'Almacen',
                'icon'        => 'ti ti-building-warehouse',
                'can'         => ['admin.materials-summary.index','admin.materials-summary.load-initial-list','admin.builder-debts-report.index','admin.materials.material-summary'],
                'submenu'     => [
                    [
                        'text'        => 'Movimientos',
                        'route'       => 'admin.materials-summary.index',
                        'can'         => ['admin.materials-summary.index'],
                        'icon'        => '',
                    ],
                    [
                        'text'        => 'Movimientos agrupados',
                        'route'       => 'admin.materials-summary.grouped-movements',
                        // 'can'         => 'admin.materials-summary.index',
                        'icon'        => '',
                    ],
                    [
                        'text'        => 'Cargar lista inicial',
                        'route'       => 'admin.materials-summary.load-initial-list',
                        'can'         => ['admin.materials-summary.load-initial-list'],
                        'icon'        => '',
                    ],
                    [
                        'text'        => 'Constructores y deudas',
                        'route'       => 'admin.builder-debts-report.index',
                        'can'         => ['admin.builder-debts-report.index'],
                        'icon'        => '',
                    ],
                    // [
                    //     'text'        => 'Salidas observadas',
                    //     'route'       => 'admin.materials-summary.duplicate-outputs',
                    //     'can'         => ['admin.materials-summary.duplicate-outputs'],
                    //     'icon'        => '',
                    // ],
                    [
                        'text'        => 'Resumen de materiales',
                        'route'       => 'admin.materials.material-summary',
                        'can'         => ['admin.materials.material-summary'],
                        'icon'        => '',
                    ],
                    [
                        'text'        => 'Depurar materiales',
                        'route'       => 'admin.materials.debug-pending-in-cre',
                        'can'         => ['admin.materials.debug-pending-in-cre'],
                        'icon'        => '',
                    ],
                    [
                        'text'        => 'Balance externo de materiales',
                        'route'       => 'admin.external-balance.index',
                        'can'         => ['admin.external-balance.index'],
                        'icon'        => '',
                    ],
                    
                ],  
            ],
            [
                'text'        => 'Poda',
                'icon'        => 'ti ti-scissors',
                'route'       => 'admin.tree-prunings.index',
                'can'         => ['admin.tree-prunings.index', 'admin.tree-prunings.create'],
            ],
            [
                'text'        => 'Estructuras',
                'icon'        => 'ti ti-box',
                'can'         => ['admin.building-structures.index','admin.building-structures.upload-default-materials'],
                'submenu'     => [
                    [
                        'text'        => 'Lista',
                        'route'       => 'admin.building-structures.index',
                        'can'         => 'admin.building-structures.index',
                        'icon'        => '',
                    ],
                    [
                        'text'        => 'Establecer materiales',
                        'route'       => 'admin.building-structures.upload-default-materials',
                        'can'         => 'admin.building-structures.upload-default-materials',
                        'icon'        => '',
                    ]
                ]
            ],
            [
                'text'        => 'Materiales',
                'icon'        => 'ti ti-shape',
                'can'         => ['admin.materials.index', 'admin.materials.create'],
                'submenu'     => [
                    [
                        'text'        => 'Lista',
                        'route'       => 'admin.materials.index',
                        'can'         => 'admin.materials.index',
                        'icon'        => '',
                    ],
                    [
                        'text'        => 'Crear',
                        'route'       => 'admin.materials.create',
                        'can'         => 'admin.materials.create',
                        'icon'        => '',
                    ],
                ]
            ],
            [
                'text'        => 'Observaciones externas',
                'icon'        => 'ti ti-eye',
                'can'         => ['admin.external-observations.index', 'admin.external-observations.create'],
                'submenu'     => [
                    [
                        'text'        => 'Lista',
                        'route'       => 'admin.external-observations.index',
                        'can'         => 'admin.external-observations.index',
                        'icon'        => '',
                    ],
                    [
                        'text'        => 'Crear',
                        'route'       => 'admin.external-observations.create',
                        'can'         => 'admin.external-observations.create',
                        'icon'        => '',
                    ]
                ]
            ],
            [
                'text'        => 'Contratos',
                'icon'        => 'ti ti-file',
                'route'       => 'admin.contracts.index',
                'can'         => ['admin.contracts.index', 'admin.contracts.create'],
            ],
            // ['header' => 'SEGURIDAD', 'can' => ['admin.users.index', 'admin.users.create', 'admin.permissions.index', 'admin.permissions.create','admin.roles.index', 'admin.roles.create']],
            [
                'text'        => 'Usuarios',
                'icon'        => 'ti ti-users',
                'can'         => ['admin.users.index', 'admin.users.create'],
                'submenu'     => [
                    [
                        'text'        => 'Lista',
                        'can'         => 'admin.users.index',
                        'route'       => 'admin.users.index',
                        'icon'        => '',
                    ],
                    [
                        'text'        => 'Crear',
                        'can'         => 'admin.users.create',
                        'route'       => 'admin.users.create',
                        'icon'        => '',
                    ]       
                ]
            ],
            [
                'text'        => 'Permisos',
                'icon'        => 'ti ti-list-check',
                'can'         => ['admin.permissions.index', 'admin.permissions.create'],
                'submenu'     => [
                    [
                        'text'        => 'Lista',
                        'route'       => 'admin.permissions.index',
                        'can'         => 'admin.permissions.index',
                        'icon'        => '',
                    ],
                    [
                        'text'        => 'Crear',
                        'route'       => 'admin.permissions.create',
                        'can'         => 'admin.permissions.create',
                        'icon'        => '',
                    ]       
                ]
            ],
            [
                'text'        => 'Roles',
                'icon'        => 'ti ti-user-check',
                'can'         => ['admin.roles.index', 'admin.roles.create'],
                'submenu'     => [
                    [
                        'text'        => 'Lista',
                        'route'       => 'admin.roles.index',
                        'can'         => 'admin.roles.index',
                        'icon'        => '',
                    ],
                    [
                        'text'        => 'Crear',
                        'route'       => 'admin.roles.create',
                        'can'         => 'admin.roles.create',
                        'icon'        => '',
                    ]       
                ]
            ],
            [
                'text'        => 'Estados de proyecto',
                'icon'        => 'ti ti-hierarchy-2',
                'can'         => ['admin.project-status.index', 'admin.project-status.create'],
                'submenu'     => [
                    [
                        'text'        => 'Lista',
                        'route'       => 'admin.project-status.index',
                        'can'         => 'admin.project-status.index',
                        'icon'        => '',
                    ],
                    [
                        'text'        => 'Crear',
                        'route'       => 'admin.project-status.create',
                        'can'         => 'admin.project-status.create',
                        'icon'        => '',
                    ]
                ]
            ],
            [
                'text'        => 'Configuracion',
                'icon'        => 'ti ti-settings',
                'can'         => ['admin.status-management-settings.edit'],
                'submenu'     => [
                    [
                        'text'        => 'Administracion de estados',
                        'route'       => 'admin.status-management-settings.edit',
                        'can'         => 'admin.status-management-settings.edit',
                        'icon'        => '',
                    ],
                ]
            ],
            // [
            //     'text'        => 'Documentacion',
            //     'icon'        => 'ti ti-smart-home',
            //     'url'       => '/administracion/docs'
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
                                unset($this->menu[$key]['submenu'][$subKey]);
                            }
                        }
                    }
                }
            }
        }
    }
}
