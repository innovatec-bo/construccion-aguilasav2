<?php
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Home
Breadcrumbs::for('admin.home.index', function (BreadcrumbTrail $trail) {
    $trail->push('Inicio', route('admin.home.index'));
});

// Labor Detail
Breadcrumbs::for('admin.labor-details.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.home.index');
    $trail->push('Manos de obra', route('admin.labor-details.index'));
});

// Labor Detail - show
Breadcrumbs::for('admin.labor-details.show', function (BreadcrumbTrail $trail, $laborDetail) {
    $trail->parent('admin.labor-details.index');
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