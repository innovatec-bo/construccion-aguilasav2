<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\WorkflowCollection;
use App\Http\Resources\WorkflowResource;
use App\Models\Workflow;
use Illuminate\Http\Request;

class WorkflowApiController extends BaseApiController
{
    /**
     * Listado paginado desde la tabla workflows (sin recalcular).
     * Usado por Serebo para el listado general de proyectos.
     *
     * GET /api/v1/workflows
     *
     * Query params opcionales:
     *   - per_page     (int, max 500, default 15)
     *   - page         (int, default 1)
     *   - search       (string)
     *   - status       (int|string separado por comas)
     *   - keyword      (string)
     *   - work_area    (string)
     *   - system       (int)
     *   - contract_id  (int)
     *   - fiscal_id    (int)
     *   - builder_id   (int)
     */
    public function index(Request $request)
    {
        $perPage = 15;
        if ($request->filled('per_page') && (int)$request->per_page <= 500)
        {
            $perPage = (int)$request->per_page;
        }

        $query = Workflow::query();

        // ── Búsqueda de texto libre ───────────────────────────────────────
        if ($request->filled('search'))
        {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('code_pro',       'like', "%{$search}%")
                  ->orWhere('detail_pro',   'like', "%{$search}%")
                  ->orWhere('address_pro',  'like', "%{$search}%")
                  ->orWhere('cre_fiscal_pro','like', "%{$search}%");
            });
        }

        // ── Filtros ───────────────────────────────────────────────────────
        if ($request->filled('keyword'))
        {
            $keywords = array_map('trim', explode(',', $request->keyword));
            $query->whereIn('keyword_pst', $keywords);
        }

        if ($request->filled('status'))
        {
            $statuses = array_map('intval', explode(',', $request->status));
            $query->whereIn('project_status_id', $statuses);
        }

        if ($request->filled('work_area'))
        {
            $query->where('work_area_pro', $request->work_area);
        }

        if ($request->filled('system'))
        {
            $query->where('system_pro', $request->system);
        }

        if ($request->filled('management_by'))
        {
            $query->where('management_by_pro', $request->management_by);
        }

        if ($request->filled('contract_id'))
        {
            $query->where('end_contract_pro', (int)$request->contract_id);
        }

        if ($request->filled('fiscal_id'))
        {
            //$query->where('fiscal_responsible_id', (int)$request->fiscal_id);
            $fiscalId = (int) $request->builder_id;
            $query->whereRaw('FIND_IN_SET(?, fiscal_responsible_id) > 0', [$fiscalId]);
        }

        if ($request->filled('builder_id'))
        {
            //$query->where('builder_responsible_id', (int)$request->builder_id);
            $builderId = (int) $request->builder_id;
            $query->whereRaw('FIND_IN_SET(?, builder_responsible_id) > 0', [$builderId]);
        }

        if ($request->filled('energized'))
        {
            $query->where('energized_pro', $request->energized == 1 ? 'Si' : 'No');
        }

        if ($request->filled('manpower_uploaded'))
        {
            if($request->manpower_uploaded == 1)
            {
                $query->whereNotNull('manpower_file_id');
            }
            elseif($request->manpower_uploaded == 0)
            {
                $query->whereNull('manpower_file_id');
            }
        }

        if ($request->filled('trim_tree'))
        {
            if ($request->trim_tree == 1)
            {
                $query->where('trim_tree', 1);
            }
            elseif ($request->trim_tree == 0)
            {
                $query->where(function ($q) {
                    $q->whereNull('trim_tree')
                    ->orWhere('trim_tree', 0);
                });
            }
        }

        $orderBy   = $request->input('order_by', 'entry_date_pro');
        $orderType = $request->input('order_type', 'desc');
        $allowedOrderBy = ['entry_date_pro', 'code_pro', 'status_log_manual_entry_date', 'static_days', 'project_current_budget'];
        if (!in_array($orderBy, $allowedOrderBy))
        {
            $orderBy = 'entry_date_pro';
        }
        $query->orderBy($orderBy, $orderType === 'asc' ? 'asc' : 'desc');
        // return $query->dumpRawSql();
        $workflows = $query->paginate($perPage);

        return $this->sendResponse(new WorkflowCollection($workflows), '');
    }

    /**
     * Devuelve 1 proyecto recalculándolo en tiempo real y actualizando la
     * tabla workflows. Usado por Serebo en la vista StatusManagement.
     *
     * GET /api/v1/workflows/{id}
     */
    public function show(int $id)
    {
        try
        {
            $workflow = Workflow::refreshProject($id);
            return $this->sendResponse(new WorkflowResource($workflow), '');
        }
        catch (\Throwable $e)
        {
            return $this->sendError(
                "No se encontró el proyecto {$id} o ocurrió un error al calcularlo.",
                ['error' => $e->getMessage()],
                404
            );
        }
    }

    /**
     * Recalcula y actualiza workflows para una lista de proyectos.
     * Llamado por Serebo cuando hay cambios de datos (eventos/hooks).
     *
     * POST /api/v1/workflows/refresh
     *
     * Body JSON:
     * {
     *   "projects": [123, 456, 789]
     * }
     */
    public function refresh(Request $request)
    {
        $request->validate([
            'projects'   => 'required|array|min:1',
            'projects.*' => 'integer',
        ]);

        try
        {
            Workflow::refreshProjects($request->projects);

            return response()->json([
                'success' => true,
                'message' => count($request->projects) . ' proyecto(s) actualizados correctamente.',
            ], 200);
        }
        catch (\Throwable $e)
        {
            return $this->sendError(
                'Error al actualizar los proyectos.',
                ['error' => $e->getMessage()],
                500
            );
        }
    }

    /**
     * Recalcula y actualiza el workflow de 1 proyecto específico.
     * Alternativa REST a /refresh para cuando Serebo actualiza 1 proyecto.
     *
     * POST /api/v1/workflows/{id}/refresh
     */
    public function refreshOne(int $id)
    {
        try
        {
            $workflow = Workflow::refreshProject($id);

            return response()->json([
                'success' => true,
                'message' => "Proyecto {$id} actualizado correctamente.",
                'data'    => new WorkflowResource($workflow),
            ], 200);
        }
        catch (\Throwable $e)
        {
            return $this->sendError(
                "Error al actualizar el proyecto {$id}.",
                ['error' => $e->getMessage()],
                500
            );
        }
    }
}