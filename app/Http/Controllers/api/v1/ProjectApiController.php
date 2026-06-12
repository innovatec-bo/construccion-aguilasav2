<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class ProjectApiController extends Controller
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
}