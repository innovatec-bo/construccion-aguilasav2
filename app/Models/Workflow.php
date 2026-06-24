<?php

namespace App\Models;

use App\CustomLibraries\WorkflowPaginationHandler;
use RichanFongdasen\EloquentBlameable\BlameableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Workflow extends Model
{
    use HasFactory;
    use SoftDeletes;
    use BlameableTrait;

    protected $casts = [
        // Fechas del proyecto base
        'entry_date_pro'                      => 'datetime',
        'folder_date_pro'                     => 'datetime',
        'cre_design_completion_date_pro'      => 'datetime',
        'cre_building_completion_date_pro'    => 'datetime',
        'schedule_start'                      => 'datetime',
        'schedule_end'                        => 'datetime',

        // Fechas de etapas del workflow
        'stake_date'                          => 'datetime',
        'returned_date'                       => 'datetime',
        'digitization_date'                   => 'datetime',
        'drawing_date'                        => 'datetime',
        'schedule_date'                       => 'datetime',
        'ready_to_send_date'                  => 'datetime',
        'already_sent_date'                   => 'datetime',
        'approved_date'                       => 'datetime',
        'canceled_date'                       => 'datetime',
        'rectify_design_date'                 => 'datetime',
        'rectify_illustration_date'           => 'datetime',
        'assign_to_date'                      => 'datetime',
        'start_date_assigned'                 => 'datetime',
        'end_date_assigned'                   => 'datetime',
        'in_progress_date'                    => 'datetime',
        'in_progress_first_detail_date'       => 'datetime',  // FIX: era string en el fillable original
        'completed_date'                      => 'datetime',
        'paused_date'                         => 'datetime',
        'stopped_date'                        => 'datetime',
        'as_built_date'                       => 'datetime',
        'conciliation_reception_date'         => 'datetime',
        'conciliation_shipment_date'          => 'datetime',
        'cre_return_order_date'               => 'datetime',
        'project_return_materials_date'       => 'datetime',
        'project_return_materials2_date'      => 'datetime',
        'project_energized_entry_date'        => 'datetime',
        'payment_order_registered_date'       => 'datetime',
        'payment_order_invoice_sent_date'     => 'datetime',
        'payment_order_has_been_settled_date' => 'datetime',
        'status_log_manual_entry_date'        => 'datetime',
        'previous_manual_entry_date'          => 'datetime',

        // Decimales
        'points_pro'                                      => 'decimal:2',
        'distance_pro'                                    => 'decimal:2',
        'schedule_design_budget'                          => 'decimal:2',
        'schedulee_tentative_total_budget'                => 'decimal:2',
        'project_current_budget'                          => 'decimal:2',
        'project_current_design_budget'                   => 'decimal:2',
        'design_budget'                                   => 'decimal:2',
        'building_budget'                                 => 'decimal:2',
        'transportation_budget'                           => 'decimal:2',
        'live_line_budget'                                => 'decimal:2',
        'right_of_way_budget'                             => 'decimal:2',
        'total_approved'                                  => 'decimal:2',
        'production_percentage'                           => 'decimal:2',
        'production_total_bs'                             => 'decimal:2',
        'percentage_paused'                               => 'decimal:2',
        'percentage_stopped'                              => 'decimal:2',
        'rd_digitization_points_quantity'                 => 'decimal:2',
        'rd_digitization_distance'                        => 'decimal:2',
        'digitization_points_quantity'                    => 'decimal:2',
        'digitization_distance'                           => 'decimal:2',
        'as_built_points_quantity'                        => 'decimal:2',
        'as_built_distance'                               => 'decimal:2',
        'payment_order_registered_design_budget'          => 'decimal:2',
        'payment_order_registered_building_budget'        => 'decimal:2',
        'payment_order_registered_transportation_budget'  => 'decimal:2',
        'payment_order_registered_live_line_budget'       => 'decimal:2',
        'payment_order_registered_right_of_way_budget'    => 'decimal:2',
        'payment_order_registered_total_real_budget'      => 'decimal:2',
        'quantity_picked_up_from_cre'                     => 'decimal:2',
        'materials_delivered_to_cre'                      => 'decimal:2',
        'quantity_materials_assigned'                     => 'decimal:2',
        'pending_material_in_cre'                         => 'decimal:2',
        'percentage_inc'                                  => 'decimal:2',
        'last_week_percentage'                            => 'decimal:2',
        'previous_percentage'                             => 'decimal:2',

        // Enteros
        'trim_tree'              => 'integer',
        'static_days'            => 'integer',
        'estimated_time_assigned'=> 'integer',
        'order_pst'              => 'integer',
    ];

    protected $fillable = [
        // Proyecto base
        'id_pro',
        'energized_pro',
        'work_area_pro',
        'project_status_id',
        'project_percentage_pro',
        'code_pro',
        'secondary_code_pro',
        'detail_pro',
        'budgetary_position_pro',
        'entry_date_pro',
        'folder_date_pro',
        'minor_enlargement',
        'end_contract_pro',
        'system_pro',
        'management_by_pro',
        'address_pro',
        'points_pro',
        'distance_pro',
        'quality_level_pro',
        'project_latitude',
        'project_longitude',
        'cre_design_completion_date_pro',
        'cre_building_completion_date_pro',
        'schedule_start',
        'schedule_end',

        // Estado del proyecto
        'status_name_pst',
        'keyword_pst',
        'order_pst',

        // Log de estado actual
        'status_log_manual_entry_date',
        'responsible',
        'static_days',

        // Stakes
        'stake_date',
        'stake_responsible_user_id',
        'stake_responsible',

        // RD Digitization
        'rd_digitization_points_quantity',
        'rd_digitization_distance',

        // Returned
        'returned_date',

        // Digitization
        'digitization_points_quantity',
        'digitization_distance',
        'digitization_date',

        // Drawing
        'drawing_date',

        // Schedule
        'schedule_date',
        'trim_tree',
        'schedule_design_budget',
        'schedulee_tentative_total_budget',

        // Presupuesto calculado
        'project_current_budget',
        'project_current_design_budget',

        // Ready to send
        'ready_to_send_date',

        // Already sent
        'already_sent_date',

        // Approved
        'approved_date',
        'approved_reservation_number',
        'approved_graph_number',
        'design_budget',
        'building_budget',
        'transportation_budget',
        'live_line_budget',
        'right_of_way_budget',
        'total_approved',
        'manpower_file_id',
        'live_line_assigned',
        'construction_assignment_id',
        'project_manager_user_id',
        'project_manager_assigned',

        // Producción
        'production_percentage',
        'production_total_bs',

        // Canceled
        'canceled_date',

        // Rectify design
        'rectify_design_date',

        // Rectify illustration
        'rectify_illustration_date',

        // Assign to
        'assign_to_date',
        'assign_to_responsible',
        'fiscal_responsible_id',
        'fiscal_responsible',
        'power_down_assigned',
        'maneuver_assigned',
        'start_date_assigned',
        'end_date_assigned',
        'estimated_time_assigned',

        // In progress
        'in_progress_date',
        'in_progress_first_detail_date',
        'builder_responsible',
        'builder_responsible_id',
        'builder_responsible_user_id',

        // Completed
        'completed_date',

        // Paused
        'paused_date',
        'percentage_paused',

        // Stopped
        'stopped_date',
        'percentage_stopped',

        // As built
        'as_built_date',
        'as_built_points_quantity',
        'as_built_distance',

        // Conciliation reception
        'conciliation_reception_date',

        // Conciliation shipment
        'conciliation_shipment_date',

        // CRE return order
        'cre_return_order_date',

        // Project return materials
        'project_return_materials_date',
        'project_return_materials2_date',

        // Project energized
        'project_energized_entry_date',

        // Payment order registered
        'payment_order_registered_date',
        'payment_order_registered_order_number',
        'payment_order_registered_contract_number',
        'payment_status',
        'payment_order_registered_invoice_number',
        'payment_order_registered_design_budget',
        'payment_order_registered_building_budget',
        'payment_order_registered_transportation_budget',
        'payment_order_registered_live_line_budget',
        'payment_order_registered_right_of_way_budget',
        'payment_order_registered_total_real_budget',

        // Payment order invoice sent
        'payment_order_invoice_sent_date',

        // Payment order settled
        'payment_order_has_been_settled_date',

        // Fiscal CRE
        'cre_fiscal_id',
        'cre_fiscal_pro',
        'cre_fiscal_email',

        // Contratos
        'initial_id_con',
        'initial_contract_number_con',
        'final_id_con',
        'final_contract_number_con',

        // Incidentes
        'percentage_inc',
        'detail_inc',
        'last_week_percentage',
        'previous_percentage',
        'previous_manual_entry_date',
        'last_three_incidents',

        // Materiales
        'quantity_picked_up_from_cre',
        'materials_delivered_to_cre',
        'quantity_materials_assigned',
        'pending_material_in_cre',

        // Placeholders (siempre vacíos, compatibilidad con datatable)
        'record_building_materials_date',
        'get_materials_date',
        'deliver_materials_date',
        'materials_reception_date',
    ];

    protected $appends = ['static_days'];

    public function getStaticDaysAttribute()
    {
        if (!$this->status_log_manual_entry_date)
        {
            return null;
        }

        return round($this->status_log_manual_entry_date->diffInDays(now()));
    }

    /**
     * Recalcula y guarda el workflow de un proyecto específico.
     * Usado cuando se consulta el StatusManagement de un proyecto.
     */
    public static function refreshProject(int $projectId) : self
    {
        $handler = new WorkflowPaginationHandler(1, 0);
        $handler->setAdditionalParameters(['id-list' => (string)$projectId]);
        $projects = $handler->getAll();

        if (empty($projects))
        {
            abort(404, "Proyecto {$projectId} no encontrado.");
        }

        $data = (array) $projects[0];

        $workflow = self::updateOrCreate(
            ['id_pro' => $projectId],
            $data
        );

        return $workflow;
    }

    /**
     * Recalcula y guarda los workflows de una lista de proyectos.
     * Usado cuando Serebo notifica cambios vía API.
     */
    public static function refreshProjects(array $projectIds) : void
    {
        if (empty($projectIds))
        {
            return;
        }

        $idList = implode("\n", $projectIds);

        $handler = new WorkflowPaginationHandler(count($projectIds), 0);
        $handler->setAdditionalParameters(['id-list' => $idList]);
        $projects = $handler->getAll();

        $sections = array_chunk($projects, 500);
        foreach ($sections as $section)
        {
            $upsertData = array_map(fn($row) => (array) $row, $section);
            self::upsert($upsertData, ['id_pro']);
        }
    }

    /**
     * Recalcula y guarda todos los proyectos (para sincronización inicial o total).
     * ⚠️ Operación pesada — usar con precaución.
     */
    public static function refreshAll() : void
    {
        $handler = new WorkflowPaginationHandler(10000, 0);
        $projects = $handler->getAll();

        // Limpiar tabla y recargar
        self::truncate();

        $sections = array_chunk($projects, 500);
        foreach ($sections as $section)
        {
            $upsertData = array_map(fn($row) => (array) $row, $section);
            self::upsert($upsertData, ['id_pro']);
        }
    }

    protected function serializeDate(\DateTimeInterface $date): string
    {
        // Si el objeto Carbon no tiene horas, minutos ni segundos, asumimos que es un cast 'date'
        if ($date->hour === 0 && $date->minute === 0 && $date->second === 0) {
            return $date->format('Y-m-d');
        }

        // Para todo lo demás (datetime), le ponemos el formato completo
        return $date->format('Y-m-d H:i:s');
    }
}