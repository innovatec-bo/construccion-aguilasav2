<?php

use App\Models\LaborCost;
use App\Models\LaborDetail;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Login
Breadcrumbs::for('login', function ($trail) {
    $trail->push('Login', route('login'));
});
// Home
Breadcrumbs::for('admin.home.index', function (BreadcrumbTrail $trail) {
    $trail->push('Inicio', route('admin.home.index'));
});

// Labor Detail
Breadcrumbs::for('admin.labor-details.index', function (BreadcrumbTrail $trail, $queryString = []) {
    $trail->parent('admin.home.index');
    $trail->push('Manos de obra', route('admin.labor-details.index', $queryString));
});

// Labor Detail - show
Breadcrumbs::for('admin.labor-details.show', function (BreadcrumbTrail $trail, LaborDetail $laborDetail, $previousQueryString = []) {
    // $trail->parent('admin.labor-details.index', $previousQueryString);
    $trail->parent('admin.home.index');
    $trail->push('Manos de obra',route('admin.labor-details.index', ['search' => $laborDetail->project->code_pro]));
    $trail->push('Detalle de Mano de obra '. $laborDetail->project->code_pro, route('admin.labor-details.index', $laborDetail));
});

// Labor Detail - internal conciliation
Breadcrumbs::for('admin.labor-details.internal-conciliation', function (BreadcrumbTrail $trail, $laborDetail, $previousRoute) {
    $trail->parent($previousRoute);
    $trail->push('Conciliacion interna '. $laborDetail->project->code_pro, route('admin.labor-details.internal-conciliation', $laborDetail));
});

// Labor Detail - internal conciliation(Builder)
Breadcrumbs::for('admin.labor-details.internal-conciliation-builder', function (BreadcrumbTrail $trail, $laborDetail, $previousRoute) {
    $trail->parent($previousRoute);
    $trail->push('Conciliacion interna (Constructor) '. $laborDetail->project->code_pro, route('admin.labor-details.internal-conciliation-builder', $laborDetail));
});

// Labor Detail - internal conciliation cre format
Breadcrumbs::for('admin.labor-details.internal-conciliation-cre-format', function (BreadcrumbTrail $trail, $laborDetail) {
    $trail->parent('admin.labor-details.index');
    $trail->push('Conciliacion interna Formato CRE '. $laborDetail->project->code_pro, route('admin.labor-details.internal-conciliation-cre-format', $laborDetail));
});

//Building structures
Breadcrumbs::for('admin.building-structures.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.home.index');
    $trail->push("Estructuras de construccion", route('admin.building-structures.index'));
});
//Building structures - show
Breadcrumbs::for('admin.building-structures.show', function (BreadcrumbTrail $trail, $buildingStructure) {
    $trail->parent('admin.building-structures.index');
    $trail->push('Estructura de construccion '.$buildingStructure->structure_code_bus, route('admin.building-structures.show', $buildingStructure));
});
//Building structures - upload default materials
Breadcrumbs::for('admin.building-structures.upload-default-materials', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.building-structures.index');
    $trail->push('Establecer materiales por defecto', route('admin.building-structures.upload-default-materials'));
});

// Materials
Breadcrumbs::for('admin.materials.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.home.index');
    $trail->push('Materiales', route('admin.materials.index'));
});
//Materials - create
Breadcrumbs::for('admin.materials.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.home.index');
    $trail->push('Crear material', route('admin.materials.create'));
});

// Materials - debug
Breadcrumbs::for('admin.materials.debug', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.home.index');
    $trail->push('Depurar materiales', route('admin.materials.debug'));
});

// Materials - summary
Breadcrumbs::for('admin.materials.material-summary', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.home.index');
    $trail->push('Resumen de materiales', route('admin.materials.material-summary'));
});

// Materials
Breadcrumbs::for('admin.materials.debug-pending-in-cre', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.home.index');
    $trail->push('Depurar materiales pendientes en CRE', route('admin.materials.debug-pending-in-cre'));
});

// Materials summary
Breadcrumbs::for('admin.materials-summary.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.home.index');
    $trail->push('Movimientos', route('admin.materials-summary.index'));
});

// Materials summary - show
Breadcrumbs::for('admin.materials-summary.show', function (BreadcrumbTrail $trail, $materialsSummary) {
    $trail->parent('admin.materials-summary.index');
    $trail->push('Detalle de movimiento '.$materialsSummary->id_msu, route('admin.materials-summary.show', $materialsSummary));
});

// Materials summary - edit
Breadcrumbs::for('admin.materials-summary.edit', function (BreadcrumbTrail $trail, $materialsSummary) {
    $trail->parent('admin.materials-summary.index');
    $trail->push('Editar movimiento '.$materialsSummary->id_msu, route('admin.materials-summary.edit', $materialsSummary));
});

// Materials summary - create
Breadcrumbs::for('admin.materials-summary.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.materials-summary.index');
    $trail->push('Registrar movimiento', route('admin.materials-summary.create'));
});

// Load initial list
Breadcrumbs::for('admin.materials-summary.load-initial-list', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.home.index');
    $trail->push('Cargar lista inicial de materiales', route('admin.materials-summary.load-initial-list'));
});

// Grouped movements
Breadcrumbs::for('admin.materials-summary.grouped-movements', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.home.index');
    $trail->push('Movimientos agrupados', route('admin.materials-summary.grouped-movements'));
});

// Grouped movements - details
Breadcrumbs::for('admin.materials-summary.grouped-movement-details', function (BreadcrumbTrail $trail, $project) {
    $trail->parent('admin.materials-summary.grouped-movements');
    $trail->push($project->code_pro, route('admin.materials-summary.grouped-movement-details', $project));
});

// External observation
Breadcrumbs::for('admin.external-observations.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.home.index');
    $trail->push('Observaciones externas', route('admin.external-observations.index'));
});
// External observation - create
Breadcrumbs::for('admin.external-observations.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.home.index');
    $trail->push('Crear observacion externa', route('admin.external-observations.create'));
});
// External observation - show
Breadcrumbs::for('admin.external-observations.show', function (BreadcrumbTrail $trail, $externalObservation) {
    $trail->parent('admin.external-observations.index');
    $trail->push('Detalle de Observacion externa '. $externalObservation->project->code_pro, route('admin.external-observations.index', $externalObservation));
});

// External observation - mark as fixed
Breadcrumbs::for('admin.external-observations.mark-as-fixed', function (BreadcrumbTrail $trail, $externalObservation) {
    $trail->parent('admin.external-observations.index');
    $trail->push('Marcar como resuelto', route('admin.external-observations.index', $externalObservation));
});

// External observation - edit
Breadcrumbs::for('admin.external-observations.edit', function (BreadcrumbTrail $trail, $externalObservation) {
    $trail->parent('admin.external-observations.index');
    $trail->push('Editar Observacion externa '. $externalObservation->project->code_pro, route('admin.external-observations.index', $externalObservation));
});

Breadcrumbs::for('admin.materials-summary.duplicate-outputs', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.home.index');
    $trail->push('Salidas duplicadas', route('admin.materials-summary.duplicate-outputs'));
});

Breadcrumbs::for('admin.builder-debts-report.index', function (BreadcrumbTrail $trail) {
    //$url = 'movimientos/movimientos-agrupados';
    //$route = app('router')->getRoutes()->match(app('request')->create($url));
    //dd($route);
    $trail->parent('admin.home.index');
    $trail->push('Reporte de deuda de constructores', route('admin.builder-debts-report.index'));
});

// Users
Breadcrumbs::for('admin.users.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.home.index');
    $trail->push('Lista de usuarios', route('admin.users.index'));
});
// Users - create
Breadcrumbs::for('admin.users.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.home.index');
    $trail->push('Crear usuario', route('admin.users.create'));
});

// Permissions
Breadcrumbs::for('admin.permissions.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.home.index');
    $trail->push('Lista de permisos', route('admin.permissions.index'));
});
// Permissions - create
Breadcrumbs::for('admin.permissions.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.home.index');
    $trail->push('Crear permiso', route('admin.permissions.create'));
});

// Permissions - edit
Breadcrumbs::for('admin.permissions.edit', function (BreadcrumbTrail $trail, $permission) {
    $trail->parent('admin.home.index');
    $trail->push('Editar permiso', route('admin.permissions.edit', $permission->id));
});

// Roles
Breadcrumbs::for('admin.roles.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.home.index');
    $trail->push('Lista de rols', route('admin.roles.index'));
});
// Roles - create
Breadcrumbs::for('admin.roles.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.home.index');
    $trail->push('Crear rol', route('admin.roles.create'));
});
// Roles - edit
Breadcrumbs::for('admin.roles.edit', function (BreadcrumbTrail $trail, $role) {
    $trail->parent('admin.home.index');
    $trail->push('Editar rol', route('admin.roles.edit', $role->id));
});

// External balance material - index
Breadcrumbs::for('admin.external-balance-material.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.home.index');
    $trail->push('Balance externo de materiales', route('admin.external-balance-material.index'));
});
// External balance material - create
Breadcrumbs::for('admin.external-balance-material.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.home.index');
    $trail->push('Importar balance externo de materiales', route('admin.external-balance-material.create'));
});

// Projects - index
Breadcrumbs::for('admin.projects.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.home.index');
    $trail->push('Proyectos', route('admin.projects.index'));
});

// Projects - status management
Breadcrumbs::for('admin.projects.status-management', function (BreadcrumbTrail $trail, $project) {
    $trail->parent('admin.home.index');
    $trail->push('Administracion de estados: '.$project->code_pro, route('admin.projects.status-management', $project));
});

// Projects - rectify manpower
Breadcrumbs::for('admin.projects.rectify-manpower', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.home.index');
    $trail->push('Rectificar mano de obra', route('admin.projects.rectify-manpower'));
});

// Labor cost log - index
Breadcrumbs::for('admin.labor-cost-log.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.home.index');
    $trail->push('Registros de avance', route('admin.labor-cost-log.index'));
});

// Contract
Breadcrumbs::for('admin.contracts.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.home.index');
    $trail->push('Contratos', route('admin.contracts.index'));
});
// Contract - edit
Breadcrumbs::for('admin.contracts.edit', function (BreadcrumbTrail $trail, $contract) {
    $trail->parent('admin.home.index');
    $trail->push('Contratos', route('admin.contracts.index'));
    $trail->push('Editar contrato '.$contract->contract_number_con, route('admin.contracts.edit', $contract));
});

// Settings - Status management
Breadcrumbs::for('admin.status-management-settings.edit', function (BreadcrumbTrail $trail) {
    $trail->push('Inicio', route('admin.home.index'));
    $trail->push('Editar configurar administracion de estados', route('admin.status-management-settings.edit'));
});

// External balance - index
Breadcrumbs::for('admin.external-balance.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.home.index');
    $trail->push('Balance externo de materiales', route('admin.external-balance.index'));
});

// External balance - show
Breadcrumbs::for('admin.external-balance.show', function (BreadcrumbTrail $trail, $externalBalance) {
    $trail->parent('admin.home.index');
    $trail->push('Balance externo de materiales', route('admin.external-balance.show', $externalBalance));
});

// Labor cost - edit
Breadcrumbs::for('admin.labor-cost.edit', function (BreadcrumbTrail $trail, LaborCost $laborCost) {
    $trail->parent('admin.home.index');
    $trail->push('Manos de obra',route('admin.labor-details.index', ['search' => $laborCost->laborDetail->project->code_pro]));
    $trail->push('Detalle de Mano de obra '. $laborCost->laborDetail->project->code_pro, route('admin.labor-details.show', $laborCost->laborDetail));
    $trail->push('Editar estructura '.$laborCost->buildingStructure->structure_code_bus, route('admin.materials-summary.edit', $laborCost));
});

// Tree pruning
Breadcrumbs::for('admin.tree-prunings.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.home.index');
    $trail->push('Podas', route('admin.tree-prunings.index'));
});