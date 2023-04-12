<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TenantDashboardMenu extends Component
{
    public $tenant;
    public $menu;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->buildMenu();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.tenant-dashboard-menu');
    }

    public function buildMenu()
    {
        $this->menu = [
            [
                'text' => 'Inicio',
                'route' => 'admin.home.index',
                'icon' => 'tf-icons ti ti-home',
            ],
            // [
            //     'text' => 'Productos',
            //     'icon' => 'tf-icons ti ti-shopping-cart',
            //         'submenu' => [
            //         [
            //             'text' => 'Lista',
            //             'route' => 'tenant.admin.products.index',
            //         ],
            //         [
            //             'text' => 'Crear',
            //             'route' => 'tenant.admin.products.create',
            //         ]
            //     ]
            // ],
            // [
            //     'text' => 'Insumos',
            //     'icon' => 'tf-icons ti ti-shopping-cart',
            //         'submenu' => [
            //         [
            //             'text' => 'Lista',
            //             'route' => 'tenant.admin.supplies.index',
            //         ],
            //         [
            //             'text' => 'Registrar compra',
            //             'route' => 'tenant.admin.supplies.register-purchase',
            //         ]
            //     ]
            // ],
            // [
            //     'text' => 'Categorizacion',
            //     'icon' => 'tf-icons ti ti-category',
            //         'submenu' => [
            //         [
            //             'text' => 'Lista',
            //             'route' => 'tenant.admin.taxonomies.index',
            //         ],
            //         [
            //             'text' => 'Crear',
            //             'route' => 'tenant.admin.taxonomies.create',
            //         ]
            //     ]
            // ],
            // [
            //     'text' => 'Mesas',
            //     'icon' => 'tf-icons ti ti-layout-grid',
            //         'submenu' => [
            //         [
            //             'text' => 'Lista',
            //             'route' => 'tenant.admin.tables.index',
            //         ],
            //         [
            //             'text' => 'Crear',
            //             'route' => 'tenant.admin.tables.create',
            //         ]
            //     ]
            // ],
            // [
            //     'text' => 'Pedidos',
            //     'icon' => 'tf-icons ti ti-receipt',
            //         'submenu' => [
            //         [
            //             'text' => 'Lista',
            //             'route' => 'tenant.admin.orders.index',
            //         ],
            //     ]
            // ],
            // [
            //     'text' => 'Configuracion',
            //     'icon' => 'tf-icons ti ti-settings',
            //         'submenu' => [
            //         [
            //             'text' => 'Horario',
            //             'route' => 'tenant.admin.products.index',
            //         ],
            //     ]
            // ],
        ];
    }
}
