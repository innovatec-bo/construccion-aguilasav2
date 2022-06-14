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
Breadcrumbs::for('admin.labor-details.internal-conciliation', function (BreadcrumbTrail $trail, $laborDetail) {
    $trail->parent('admin.labor-details.index');
    $trail->push('Conciliacion interna '. $laborDetail->project->code_pro, route('admin.labor-details.internal-conciliation', $laborDetail));
});

// Labor Detail - internal conciliation(Builder)
Breadcrumbs::for('admin.labor-details.internal-conciliation-builder', function (BreadcrumbTrail $trail, $laborDetail) {
    $trail->parent('admin.labor-details.index');
    $trail->push('Conciliacion interna (Constructor) '. $laborDetail->project->code_pro, route('admin.labor-details.internal-conciliation-builder', $laborDetail));
});

// Labor Detail - internal conciliation cre format
Breadcrumbs::for('admin.labor-details.internal-conciliation-cre-format', function (BreadcrumbTrail $trail, $laborDetail) {
    $trail->parent('admin.labor-details.index');
    $trail->push('Conciliacion interna Formato CRE '. $laborDetail->project->code_pro, route('admin.labor-details.internal-conciliation-cre-format', $laborDetail));
});