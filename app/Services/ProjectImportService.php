<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Exception;

class ProjectImportService
{
    public function importByCode(string $code): array
    {
        // 1. Validar existencia en Águila
        if (DB::table('wfl_projects')->where('code_pro', $code)->exists()) {
            throw new Exception("El proyecto {$code} ya existe en Águila.");
        }

        // 2. Obtener datos desde Serebo
        $url = rtrim(config('services.serebo2.url'), '/') . "/projects/{$code}/export";
        $response = Http::withToken(config('services.serebo2.token'))
            ->timeout(90)
            ->get($url);

        if ($response->failed()) {
            throw new Exception($response->json('message') ?? "Error HTTP {$response->status()} al conectar con Serebo.");
        }

        $data = $response->json();
        if (empty($data['wfl_projects'])) {
            throw new Exception("La respuesta de Serebo no contiene los datos del proyecto.");
        }

        $generics = $this->getGenericUsersMap();
        $sourceProject = (array) $data['wfl_projects'];
        $oldProjectId  = $sourceProject['id_pro'];

        return DB::transaction(function () use ($data, $sourceProject, $oldProjectId, $code, $generics) {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');

            try {
                // A. Insertar Proyecto principal usando AUTO_INCREMENT propio
                unset($sourceProject['id_pro']); // Dejar que Águila asigne el ID correlativo
                if (!empty($sourceProject['cre_fiscal_pro'])) {
                    $sourceProject['cre_fiscal_pro'] = $generics['fiscal_cre'];
                }

                $newProjectId = DB::table('wfl_projects')->insertGetId($sourceProject);

                // B. Vista desnormalizada workflows
                if (!empty($data['workflows'])) {
                    $wf = (array) $data['workflows'];
                    unset($wf['id']);
                    $wf['id_pro']          = $newProjectId;
                    $wf['cre_fiscal_pro']  = 'Fiscal CRE Genérico';
                    $wf['cre_fiscal_id']   = $generics['fiscal_cre'];
                    $wf['responsible']     = 'Encargado Genérico';
                    DB::table('workflows')->insertOrIgnore($wf);
                }

                // C. Mapeo de wfl_project_status_log (necesario para presupuestos y puntos)
                $statusLogMap = []; // [old_id_psl => new_id_psl]
                foreach ($data['wfl_project_status_log'] ?? [] as $log) {
                    $item = (array) $log;
                    $oldPslId = $item['id_psl'];
                    unset($item['id_psl']);
                    $item['project_id_psl'] = $newProjectId;

                    $newPslId = DB::table('wfl_project_status_log')->insertGetId($item);
                    $statusLogMap[$oldPslId] = $newPslId;
                }

                // Puntos de proyecto y presupuestos vinculados al nuevo status_log
                $projectPoints = array_map(function ($row) use ($statusLogMap) {
                    $item = (array) $row;
                    unset($item['id_prp']);
                    $item['status_log_id_prp'] = $statusLogMap[$item['status_log_id_prp']] ?? null;
                    return $item;
                }, $data['wfl_project_points'] ?? []);
                $this->bulkInsert('wfl_project_points', $projectPoints);

                $projectBudgets = array_map(function ($row) use ($statusLogMap) {
                    $item = (array) $row;
                    unset($item['id_prb']);
                    $item['status_log_id_prb'] = $statusLogMap[$item['status_log_id_prb']] ?? null;
                    return $item;
                }, $data['wfl_project_budgets'] ?? []);
                $this->bulkInsert('wfl_project_budgets', $projectBudgets);

                $realBudgets = array_map(function ($row) use ($statusLogMap) {
                    $item = (array) $row;
                    unset($item['id_reb']);
                    $item['status_log_id_reb'] = $statusLogMap[$item['status_log_id_reb']] ?? null;
                    return $item;
                }, $data['wfl_project_real_budgets'] ?? []);
                $this->bulkInsert('wfl_project_real_budgets', $realBudgets);

                $assignments = array_map(function ($row) use ($statusLogMap, $generics) {
                    $item = (array) $row;
                    unset($item['id_cas']);
                    $item['status_log_id_cas']   = $statusLogMap[$item['status_log_id_cas']] ?? null;
                    $item['project_manager_cas'] = $generics['encargado'];
                    return $item;
                }, $data['wfl_construction_assignments'] ?? []);
                $this->bulkInsert('wfl_construction_assignments', $assignments);

                $statusLogResp = array_map(function ($row) use ($statusLogMap, $generics) {
                    $item = (array) $row;
                    unset($item['id_slr']);
                    $item['status_log_id_slr']   = $statusLogMap[$item['status_log_id_slr']] ?? null;
                    $item['responsible_id_slr']  = $generics['encargado_sre'] ?? $item['responsible_id_slr'];
                    return $item;
                }, $data['wfl_status_log_responsibles'] ?? []);
                $this->bulkInsert('wfl_status_log_responsibles', $statusLogResp);

                // D. Operaciones directas de proyecto
                $stakes = array_map(function ($row) use ($newProjectId) {
                    $item = (array) $row;
                    unset($item['id_prs']);
                    $item['project_id_prs'] = $newProjectId;
                    return $item;
                }, $data['wfl_project_stakes'] ?? []);
                $this->bulkInsert('wfl_project_stakes', $stakes);

                $limits = array_map(function ($row) use ($newProjectId) {
                    $item = (array) $row;
                    unset($item['id_prl']);
                    $item['project_id_prl'] = $newProjectId;
                    return $item;
                }, $data['wfl_production_limits'] ?? []);
                $this->bulkInsert('wfl_production_limits', $limits);

                $incidents = array_map(function ($row) use ($newProjectId) {
                    $item = (array) $row;
                    unset($item['id_inc']);
                    $item['project_id_inc'] = $newProjectId;
                    return $item;
                }, $data['wfl_incidents'] ?? []);
                $this->bulkInsert('wfl_incidents', $incidents);

                $datesToWork = array_map(function ($row) use ($newProjectId) {
                    $item = (array) $row;
                    unset($item['id_wpl']);
                    $item['project_id_wpl'] = $newProjectId;
                    return $item;
                }, $data['wfl_dates_to_work'] ?? []);
                $this->bulkInsert('wfl_dates_to_work', $datesToWork);

                $workPlanDates = array_map(function ($row) use ($newProjectId) {
                    $item = (array) $row;
                    unset($item['id_wpd']);
                    $item['project_id_wpd'] = $newProjectId;
                    return $item;
                }, $data['wfl_work_plan_dates'] ?? []);
                $this->bulkInsert('wfl_work_plan_dates', $workPlanDates);

                // E. Mano de Obra: bui_labor_details y bui_labor_cost
                $laborCostMap = []; // [old_id_lac => new_id_lac]
                foreach ($data['bui_labor_details'] ?? [] as $lad) {
                    $ladItem = (array) $lad;
                    $oldLadId = $ladItem['id_lad'];
                    unset($ladItem['id_lad']);
                    $ladItem['project_id_lad'] = $newProjectId;

                    $newLadId = DB::table('bui_labor_details')->insertGetId($ladItem);

                    // Insertar sus costos hijos
                    $costs = array_filter($data['bui_labor_cost'] ?? [], fn($c) => $c['labor_detail_id_lac'] == $oldLadId);
                    foreach ($costs as $cost) {
                        $costItem = (array) $cost;
                        $oldLacId = $costItem['id_lac'];
                        unset($costItem['id_lac']);
                        $costItem['labor_detail_id_lac'] = $newLadId;

                        $newLacId = DB::table('bui_labor_cost')->insertGetId($costItem);
                        $laborCostMap[$oldLacId] = $newLacId;
                    }
                }

                // bui_building_points
                $pointMap = []; // [old_id_bpo => new_id_bpo]
                foreach ($data['bui_building_points'] ?? [] as $bpo) {
                    $bpoItem = (array) $bpo;
                    $oldBpoId = $bpoItem['id_bpo'];
                    unset($bpoItem['id_bpo']);
                    $bpoItem['project_id_bpo'] = $newProjectId;

                    $newBpoId = DB::table('bui_building_points')->insertGetId($bpoItem);
                    $pointMap[$oldBpoId] = $newBpoId;
                }

                // bui_structure_by_points
                $structureByPoints = array_map(function ($row) use ($newProjectId, $pointMap, $laborCostMap) {
                    $item = (array) $row;
                    unset($item['id_sbp']);
                    $item['project_id_sbp']    = $newProjectId;
                    $item['point_id_sbp']      = $pointMap[$item['point_id_sbp']] ?? null;
                    $item['labor_cost_id_sbp'] = $laborCostMap[$item['labor_cost_id_sbp']] ?? null;
                    return $item;
                }, $data['bui_structure_by_points'] ?? []);
                $this->bulkInsert('bui_structure_by_points', $structureByPoints);

                // Materiales personalizados de estructura
                $customMaterials = array_map(function ($row) use ($newProjectId, $laborCostMap) {
                    $item = (array) $row;
                    unset($item['id_csm']);
                    $item['project_id_csm'] = $newProjectId;
                    $item['labor_cost_id']  = $laborCostMap[$item['labor_cost_id']] ?? null;
                    return $item;
                }, $data['bui_custom_structure_materials'] ?? []);
                $this->bulkInsert('bui_custom_structure_materials', $customMaterials);

                // bui_labor_cost_log y bui_worked_up_structures
                $lalMap = [];
                foreach ($data['bui_labor_cost_log'] ?? [] as $lal) {
                    $lalItem = (array) $lal;
                    $oldLalId = $lalItem['id_lal'];
                    unset($lalItem['id_lal']);
                    $lalItem['user_id_lal'] = $generics['constructor'];
                    $lalItem['point_id_lal'] = $pointMap[$lalItem['point_id_lal']] ?? null;

                    $newLalId = DB::table('bui_labor_cost_log')->insertGetId($lalItem);
                    $lalMap[$oldLalId] = $newLalId;
                }

                $workedUp = array_map(function ($row) use ($lalMap, $laborCostMap) {
                    $item = (array) $row;
                    unset($item['id_wus']);
                    $item['labor_cost_log_id_wus'] = $lalMap[$item['labor_cost_log_id_wus']] ?? null;
                    $item['labor_cost_id_wus']     = $laborCostMap[$item['labor_cost_id_wus']] ?? null;
                    return $item;
                }, $data['bui_worked_up_structures'] ?? []);
                $this->bulkInsert('bui_worked_up_structures', $workedUp);

                $builders = array_map(function ($row) use ($lalMap, $generics) {
                    $item = (array) $row;
                    unset($item['id_bim']);
                    $item['labor_cost_log_id_bim'] = $lalMap[$item['labor_cost_log_id_bim']] ?? null;
                    $item['user_id_bim']           = $generics['constructor'];
                    return $item;
                }, $data['bui_builders_in_manpower'] ?? []);
                $this->bulkInsert('bui_builders_in_manpower', $builders);

                // F. Materiales (mat_)
                $msuMap = [];
                foreach ($data['mat_materials_summary'] ?? [] as $msu) {
                    $msuItem = (array) $msu;
                    $oldMsuId = $msuItem['id_msu'];
                    unset($msuItem['id_msu']);
                    $msuItem['project_id_msu']           = $newProjectId;
                    $msuItem['fiscal_responsible_msu']   = $generics['fiscal'];
                    $msuItem['builder_responsible_msu']  = $generics['constructor'];

                    $newMsuId = DB::table('mat_materials_summary')->insertGetId($msuItem);
                    $msuMap[$oldMsuId] = $newMsuId;
                }

                $projectsMaterials = array_map(function ($row) use ($msuMap) {
                    $item = (array) $row;
                    unset($item['id_prm']);
                    $item['materials_summary_id_prm'] = $msuMap[$item['materials_summary_id_prm']] ?? null;
                    return $item;
                }, $data['mat_projects_materials'] ?? []);
                $this->bulkInsert('mat_projects_materials', $projectsMaterials);

                // Operaciones de almacén interno
                $iwoMap = [];
                foreach ($data['mat_internal_warehouse_operations'] ?? [] as $iwo) {
                    $iwoItem = (array) $iwo;
                    $oldIwoId = $iwoItem['id_iwo'];
                    unset($iwoItem['id_iwo']);
                    $iwoItem['project_id_iwo'] = $newProjectId;
                    $iwoItem['fiscal_id_iwo']  = $generics['fiscal'];
                    $iwoItem['builder_id_iwo'] = $generics['constructor'];

                    $newIwoId = DB::table('mat_internal_warehouse_operations')->insertGetId($iwoItem);
                    $iwoMap[$oldIwoId] = $newIwoId;
                }

                $internals = array_map(function ($row) use ($iwoMap) {
                    $item = (array) $row;
                    unset($item['id_int']);
                    $item['operation_id_int'] = $iwoMap[$item['operation_id_int']] ?? null;
                    return $item;
                }, $data['mat_internals'] ?? []);
                $this->bulkInsert('mat_internals', $internals);

                return [
                    'status' => 'ok',
                    'code'   => $code,
                    'name'   => $sourceProject['project_name_pro'] ?? '',
                    'id_pro' => $newProjectId,
                ];
            } finally {
                DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            }
        });
    }

    private function getGenericUsersMap(): array
    {
        $users = DB::table('sec_users')
            ->whereIn('email', [
                'diseniador.generico@aguilasa.com',
                'estaqueador.generico@aguilasa.com',
                'digitalizador.generico@aguilasa.com',
                'constructor.generico@aguilasa.com',
                'fiscal.generico@aguilasa.com',
                'fiscal.cre.generico@aguilasa.com',
                'encargado.generico@aguilasa.com',
            ])
            ->pluck('id_usr', 'email');

        $firstSre = DB::table('wfl_status_responsibles')->where('deleted_sre', 0)->value('id_sre');

        return [
            'diseniador'    => $users['diseniador.generico@aguilasa.com'] ?? 1,
            'estaqueador'   => $users['estaqueador.generico@aguilasa.com'] ?? 1,
            'digitalizador' => $users['digitalizador.generico@aguilasa.com'] ?? 1,
            'constructor'   => $users['constructor.generico@aguilasa.com'] ?? 1,
            'fiscal'        => $users['fiscal.generico@aguilasa.com'] ?? 1,
            'fiscal_cre'    => $users['fiscal.cre.generico@aguilasa.com'] ?? 1,
            'encargado'     => $users['encargado.generico@aguilasa.com'] ?? 1,
            'encargado_sre' => $firstSre,
        ];
    }

    private function bulkInsert(string $table, ?array $rows): void
    {
        if (empty($rows)) {
            return;
        }

        foreach (array_chunk($rows, 100) as $chunk) {
            $mapped = array_map(fn($row) => (array) $row, $chunk);
            DB::table($table)->insertOrIgnore($mapped);
        }
    }
}