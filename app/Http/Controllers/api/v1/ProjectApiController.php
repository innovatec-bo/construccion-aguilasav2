<?php

namespace App\Http\Controllers\api\v1;

use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class ProjectApiController extends BaseApiController
{
    public function index(Request $request)
    {
        // 1. Parámetros que envía DataTables de manera predeterminada
        $draw = $request->input('draw', 1);
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        $search = $request->input('search.value', '');
        
        // Mapeo de columnas para el ordenamiento (ajusta según el orden de tus th en CI3)
        $columns = [
            0 => 'code_pro',
            1 => 'entry_date_pro',
            // Agrega el resto de columnas según corresponda
        ];
        
        $orderColumnIndex = $request->input('order.0.column', 0);
        $orderDir = $request->input('order.0.dir', 'desc');
        $sort = $columns[$orderColumnIndex] ?? 'entry_date_pro';

        // 2. Base de la consulta con las relaciones necesarias (Eager Loading)
        // Esto es clave para la velocidad (evita el problema N+1 que seguro sufre CI3)
        $query = Project::with(['status', 'system', 'creFiscal']);

        // 3. Total de registros antes de filtrar
        $recordsTotal = $query->count();

        // 4. Aplicar filtros dinámicos (Clonando la lógica de tu Livewire)
        $query->when($search, function (Builder $q, $search) {
            $q->where('code_pro', 'like', '%' . $search . '%')
              ->orWhere('address_pro', 'like', '%' . $search . '%');
              // Puedes añadir más campos de búsqueda aquí si es necesario
        })
        ->when($request->input('work_area'), function (Builder $q, $workArea) {
            $q->where('work_area_pro', $workArea);
        })
        ->when($request->input('status_selected'), function (Builder $q, $status) {
            $q->where('status_pro', $status);
        });

        // 5. Total de registros filtrados
        $recordsFiltered = $query->count();

        // 6. Paginación y ordenamiento
        // Calculamos la página actual en base a lo que pide DataTables
        $page = ($start / $length) + 1;
        
        $projects = $query->orderBy($sort, $orderDir)
                          ->paginate($length, ['*'], 'page', $page);

        // 7. Formatear la data para que DataTables la entienda directamente
        $data = [];
        foreach ($projects as $project) {
            $builderResponsible = "";
            $fiscalResponsible = "";
            foreach ($project->statusLogResponsibles as $statusLogResponsible)
            {
                if ($statusLogResponsible->responsible->user->hasRole('Fiscal'))
                {
                    $fiscalResponsible .= $statusLogResponsible->responsible->user->full_name.', ';
                }
                if ($statusLogResponsible->responsible->user->hasRole('Builder'))
                {
                    $builderResponsible .= $statusLogResponsible->responsible->user->full_name.', ';
                }
            }
            $fiscalResponsible = substr($fiscalResponsible, 0, -2);
            $builderResponsible = substr($builderResponsible, 0, -2);
                
            $data[] = [
                'id_pro'          => $project->id_pro,
                'order_pst'       => $project->status->order_pst ?? '',
                'code_pro'        => $project->code_pro,
                'entry_date_pro'  => $project->entry_date_pro->format('Y-m-d H:i:s'),
                'status_log_manual_entry_date' => $project->currentStatusLog->manual_entry_date_psl->format('Y-m-d H:i:s'),
                'static_days'     => round($project->currentStatusLog->manual_entry_date_psl->diffInDays(Carbon::now())),
                'status_name_pst' => $project->status->status_name_pst ?? '',
                'entry_date'      => $project->entry_date_pro->format('d/m/Y'),
                'entry_diff'      => $project->entry_date_pro->diffForHumans(),
                'system_pro'      => $project->system->name ?? '',
                'cre_fiscal_pro'  => $project->creFiscal->fullName ?? 'N/A',
                'fiscal_responsible' => $fiscalResponsible,
                'builder_responsible' => $builderResponsible,
                'distance_pro'    => $project->distance_pro,
                'points_pro'      => $project->points_pro,
                'points_distance' => $project->points_pro . 'p / ' . $project->distance_pro . 'Km',
                'address_pro'     => $project->address_pro,
                'project_status_id' => $project->status_pro,
                'project_current_budget'  => $project->currentBudget,
            ];
        }

        // 8. Respuesta JSON estándar de DataTables
        return response()->json([
            'draw'            => intval($draw),
            'recordsTotal'    => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data'            => $data
        ]);
    }

    public function export(string $code)
    {
        // 1. Cabecera del proyecto
        $project = DB::table('wfl_projects')->where('code_pro', $code)->where('deleted_at', null)->where('deleted_pro','!=',1)->first();

        if (!$project) {
            return response()->json(['message' => "Proyecto {$code} no encontrado."], 404);
        }

        $idPro = $project->id_pro;

        // 2. Registro desnormalizado en workflows
        $workflow = DB::table('workflows')->where('id_pro', $idPro)->first();

        // 3. Status Logs (clave para presupuestos, puntos de proyecto y asignaciones)
        $statusLogs = DB::table('wfl_project_status_log')
            ->where('project_id_psl', $idPro)
            ->get();
        $statusLogIds = $statusLogs->pluck('id_psl')->toArray();

        $projectPoints = [];
        $projectBudgets = [];
        $projectRealBudgets = [];
        $constructionAssignments = [];
        $statusLogResponsibles = [];

        if (!empty($statusLogIds)) {
            $projectPoints = DB::table('wfl_project_points')
                ->whereIn('status_log_id_prp', $statusLogIds)
                ->get();

            $projectBudgets = DB::table('wfl_project_budgets')
                ->whereIn('status_log_id_prb', $statusLogIds)
                ->get();

            $projectRealBudgets = DB::table('wfl_project_real_budgets')
                ->whereIn('status_log_id_reb', $statusLogIds)
                ->get();

            $constructionAssignments = DB::table('wfl_construction_assignments')
                ->whereIn('status_log_id_cas', $statusLogIds)
                ->get();

            $statusLogResponsibles = DB::table('wfl_status_log_responsibles')
                ->whereIn('status_log_id_slr', $statusLogIds)
                ->get();
        }

        // 4. Operaciones directas de proyecto
        $projectStakes    = DB::table('wfl_project_stakes')->where('project_id_prs', $idPro)->get();
        $productionLimits = DB::table('wfl_production_limits')->where('project_id_prl', $idPro)->get();
        $incidents        = DB::table('wfl_incidents')->where('project_id_inc', $idPro)->get();
        $datesToWork      = DB::table('wfl_dates_to_work')->where('project_id_wpl', $idPro)->get();
        $workPlanDates    = DB::table('wfl_work_plan_dates')->where('project_id_wpd', $idPro)->get();

        // 5. Mano de Obra (bui_)
        $laborDetails = DB::table('bui_labor_details')->where('project_id_lad', $idPro)->get();
        $ladIds       = $laborDetails->pluck('id_lad')->toArray();

        $laborCosts = !empty($ladIds)
            ? DB::table('bui_labor_cost')->whereIn('labor_detail_id_lac', $ladIds)->get()
            : collect([]);
        $lacIds = $laborCosts->pluck('id_lac')->toArray();

        $buildingPoints    = DB::table('bui_building_points')->where('project_id_bpo', $idPro)->get();
        $structureByPoints = DB::table('bui_structure_by_points')->where('project_id_sbp', $idPro)->get();

        $customStructureMaterials = !empty($lacIds)
            ? DB::table('bui_custom_structure_materials')->whereIn('labor_cost_id', $lacIds)->get()
            : collect([]);

        $workedUpStructures = !empty($lacIds)
            ? DB::table('bui_worked_up_structures')->whereIn('labor_cost_id_wus', $lacIds)->get()
            : collect([]);

        $lalIds = $workedUpStructures->pluck('labor_cost_log_id_wus')->filter()->unique()->toArray();
        $laborCostLogs = !empty($lalIds)
            ? DB::table('bui_labor_cost_log')->whereIn('id_lal', $lalIds)->get()
            : collect([]);

        $buildersInManpower = !empty($lalIds)
            ? DB::table('bui_builders_in_manpower')->whereIn('labor_cost_log_id_bim', $lalIds)->get()
            : collect([]);

        // 6. Materiales (mat_)
        $materialsSummary = DB::table('mat_materials_summary')->where('project_id_msu', $idPro)->get();
        $msuIds           = $materialsSummary->pluck('id_msu')->toArray();

        $projectsMaterials = !empty($msuIds)
            ? DB::table('mat_projects_materials')->whereIn('materials_summary_id_prm', $msuIds)->get()
            : collect([]);

        $warehouseOps = DB::table('mat_internal_warehouse_operations')->where('project_id_iwo', $idPro)->get();
        $iwoIds       = $warehouseOps->pluck('id_iwo')->toArray();

        $matInternals = !empty($iwoIds)
            ? DB::table('mat_internals')->whereIn('operation_id_int', $iwoIds)->get()
            : collect([]);

        return response()->json([
            'wfl_projects'                      => $project,
            'workflows'                         => $workflow,
            'wfl_project_status_log'            => $statusLogs,
            'wfl_project_points'                => $projectPoints,
            'wfl_project_budgets'               => $projectBudgets,
            'wfl_project_real_budgets'          => $projectRealBudgets,
            'wfl_construction_assignments'      => $constructionAssignments,
            'wfl_status_log_responsibles'       => $statusLogResponsibles,
            'wfl_project_stakes'                => $projectStakes,
            'wfl_production_limits'             => $productionLimits,
            'wfl_incidents'                     => $incidents,
            'wfl_dates_to_work'                 => $datesToWork,
            'wfl_work_plan_dates'               => $workPlanDates,
            'bui_labor_details'                 => $laborDetails,
            'bui_labor_cost'                    => $laborCosts,
            'bui_building_points'               => $buildingPoints,
            'bui_structure_by_points'           => $structureByPoints,
            'bui_custom_structure_materials'    => $customStructureMaterials,
            'bui_labor_cost_log'                => $laborCostLogs,
            'bui_worked_up_structures'          => $workedUpStructures,
            'bui_builders_in_manpower'          => $buildersInManpower,
            'mat_materials_summary'             => $materialsSummary,
            'mat_projects_materials'            => $projectsMaterials,
            'mat_internal_warehouse_operations' => $warehouseOps,
            'mat_internals'                     => $matInternals,
        ]);
    }
}