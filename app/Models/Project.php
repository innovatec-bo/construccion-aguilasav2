<?php

namespace App\Models;

use RichanFongdasen\EloquentBlameable\BlameableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Project extends Model
{
    use HasFactory;
    use SoftDeletes;
    use BlameableTrait;
    
    protected $table = "wfl_projects";
    protected $primaryKey = "id_pro";

    const CREATED_AT = 'createdon_pro';
    const UPDATED_AT = 'editedon_pro';

    protected $fillable = [
        'initial_design_budget_pro',
        'initial_building_budget_pro',
        'code_pro',
        'work_area_pro',
        'project_year_pro',
        'contract_id_pro',
        'end_contract_pro',
        'detail_pro',
        'address_pro',
        'entry_date_pro',
        'folder_date_pro',
        'cre_fiscal_pro',
        'system_pro',
        'management_by_pro',
        'quality_level_pro',
        'cre_design_completion_date_pro',
        'cre_building_completion_date_pro',
        'budgetary_position_pro',
        'points_pro',
        'distance_pro',
        'minor_enlargement',
        'status_pro',
        'latitude_pro',
        'longitude_pro'
    ];

    protected $casts = [
        'entry_date_pro' => 'datetime',
        'project_has_returned_materials_to_cre' => 'boolean'
    ];

    public function materialSummaries()
    {
        return $this->hasMany(MaterialSummary::class, 'project_id_msu');
    }

    public function status()
    {
        return $this->belongsTo(ProjectStatus::class, 'status_pro');
    }

    public function statusLog()
    {
        return $this->hasMany(ProjectStatusLog::class, 'project_id_psl')->orderBy('manual_entry_date_psl', 'desc');
    }

    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id_pro');
    }

    public function statusLogResponsibles()
    {
        return $this->hasManyThrough(StatusLogResponsible::class, ProjectStatusLog::class,'project_id_psl', 'status_log_id_slr')
        // ->whereHas('responsible', function(Builder $query){
            // $query->whereHas('user', function(Builder $query){
                // $query->with('roles')->whereHas('roles',function(Builder $query){
                    // $query->whereIn('name',['Builder']);
                // });
            // });
        // })
        ->where('status_id_psl',29)
        ->limit(2)
        ->orderBy('manual_entry_date_psl','desc');
    }

    public function builderResponsible__()
    {
        return $this->hasOne(ProjectStatusLog::class, 'project_id_psl')->ofMany([
            'manual_entry_date_psl' => 'max'
        ], function($query){
            $query->where('status_id_psl', 29);
        });
    }

    // public function getBuilderResponsibleAttribute()
    // {
    //     return User::role('builder')
    //     ->whereHas('statusResponsible', function(Builder $query){
    //         $query->whereHas('statusLogResponsible', function(Builder $query){
    //             $query->whereHas('projectStatusLog', function(Builder $query){
    //                 $query->where('status_id_psl', 29);
    //             });
    //         });
    //     })->get();
    // }

    public function laborDetailDesign()
    {
        return $this->hasOne(LaborDetail::class, 'project_id_lad')->where('status_id_lad', 11);//Approved
    }

    public function laborDetailBuilding()
    {
        return $this->hasOne(LaborDetail::class, 'project_id_lad')->where('status_id_lad', 34);//Conciliation reception
    }

    /**
	 * This method is a query complement of getWorkflowDetail method.
	 * @param $statusId
	 * @param bool $showFirstDetail
	 * @return string
	 */
    public static function statusDetailQuery($statusId, bool $showFirstDetail = FALSE) : string
    {
        $entryCriteria = 'MAX';
        if($showFirstDetail)
		{
			$entryCriteria = 'MIN';
		}
        $sql = "
        select 
			id_psl,
			project_id_psl,
			status_id_psl,	
			filter.entry_date,
			GROUP_CONCAT(CONCAT(responsible.id_usr)) responsible_user_id,
			GROUP_CONCAT(CONCAT(responsible.firstname_usr,' ',responsible.lastname_usr)) responsible,
			GROUP_CONCAT(CONCAT(builder.builder_id)) builder_responsible_id,
			GROUP_CONCAT(CONCAT(builder.builder_firstname,' ',builder.builder_lastname)) builder_responsible,
			-- fiscal.fiscal_id fiscal_responsible_id,
			GROUP_CONCAT(CONCAT(fiscal.fiscal_id)) fiscal_responsible_id,
			GROUP_CONCAT(CONCAT(fiscal.fiscal_firstname,' ',fiscal.fiscal_lastname)) fiscal_responsible,
			design_prb,
			building_prb,			
			transportation_prb,
			live_line_prb,
			right_of_way_prb,
            manpower_file_id_prb manpower_file_id,
			(IFNULL(design_prb,0) + IFNULL(building_prb,0) + IFNULL(transportation_prb,0) + IFNULL(live_line_prb,0) + IFNULL(right_of_way_prb,0)) as total_budget,
            tentative_total_budget_prb,
            reservation_number_prb,
            graph_number_prb,
            trim_tree_prb,
			design_reb,
			building_reb,			
			transportation_reb,
			live_line_reb,
			right_of_way_reb,
			(IFNULL(design_reb,0) + IFNULL(building_reb,0) + IFNULL(transportation_reb,0) + IFNULL(live_line_reb,0) + IFNULL(right_of_way_reb,0)) as total_real_budget,
			id_cas construction_assignment_id,
            start_date_cas,
			end_date_cas,
			estimated_time_cas,
			live_line_cas,
			power_down_cas,
			maneuver_cas,
            project_manager.id_usr project_manager_id,
            CONCAT(project_manager.firstname_usr,' ',project_manager.lastname_usr) project_manager_full_name,
			pauseOnIncident.percentage_inc percentage_paused,
			stopOnIncident.percentage_inc percentage_stopped,
			points_quantity_prp,
			distance_prp
		from 
			wfl_project_status_log
		RIGHT JOIN(
            SELECT			
                project_id_psl project_id,
                {$entryCriteria}(manual_entry_date_psl) as 'entry_date'
            FROM
                wfl_project_status_log
            WHERE		
            status_id_psl = ".$statusId." {id-list-psl}
            and deleted_psl != 1
            
            GROUP BY project_id_psl
		) as filter on filter.entry_date = manual_entry_date_psl and filter.project_id = project_id_psl
		LEFT JOIN wfl_projects on id_pro = project_id_psl
		LEFT JOIN (
                    select 
                        wfl_incidents.* 
                    from 
                        wfl_incidents
                    RIGHT JOIN 
                    (
                        SELECT
                            project_id_inc project_id,
                            MAX(manual_entry_date_inc) AS entry_date
                        FROM
                            wfl_incidents
                        where 
                            paused_inc = 1
                        and deleted_inc != 1 {id-list-inc}
                        GROUP BY
                            project_id_inc
                    ) last_incidents on last_incidents.project_id = project_id_inc and last_incidents.entry_date = manual_entry_date_inc
                ) pauseOnIncident on pauseOnIncident.project_id_inc = id_pro
        LEFT JOIN (
            select 
                wfl_incidents.* 
            from 
                wfl_incidents
            RIGHT JOIN 
            (
                SELECT
                    project_id_inc project_id,
                    MAX(manual_entry_date_inc) AS entry_date
                FROM
                    wfl_incidents
                where 
                    stopped_inc = 1
                and deleted_inc != 1 {id-list-inc}
                GROUP BY
                    project_id_inc
            ) last_incidents on last_incidents.project_id = project_id_inc and last_incidents.entry_date = manual_entry_date_inc
        ) stopOnIncident on stopOnIncident.project_id_inc = id_pro
		LEFT JOIN wfl_status_log_responsibles on wfl_status_log_responsibles.status_log_id_slr = id_psl
		LEFT JOIN wfl_status_responsibles on responsible_id_slr = id_sre		
		LEFT JOIN sec_users responsible on user_id_sre = responsible.id_usr
		LEFT JOIN (
                SELECT
                    id_usr builder_id,
                    firstname_usr builder_firstname,
                    lastname_usr builder_lastname
                FROM
                    sec_users
                right JOIN sec_userroles on userid_uro = id_usr
                where 
                    roleid_uro = 9
                and deleted_uro != 1
            ) as builder on builder.builder_id = user_id_sre
		LEFT JOIN (
                SELECT
                    id_usr fiscal_id,
                    firstname_usr fiscal_firstname,
                    lastname_usr fiscal_lastname
                FROM
                    sec_users
                right JOIN sec_userroles on userid_uro = id_usr
                where 
                    roleid_uro = 8
                and deleted_uro != 1
            ) as fiscal on fiscal.fiscal_id = user_id_sre		
		LEFT JOIN wfl_project_budgets on status_log_id_prb = id_psl
		LEFT JOIN wfl_project_real_budgets on status_log_id_reb = id_psl
		LEFT JOIN wfl_construction_assignments on status_log_id_cas = id_psl
		left join wfl_project_points on status_log_id_prp = id_psl
        left join sec_users project_manager on project_manager_cas = project_manager.id_usr
		where deleted_pro != 1 and deleted_slr != 1 {code-list} {id-list}
		GROUP BY id_psl
        ";
        return $sql;
    }

    /**
	 * @param $statusId
	 * @param bool $showFirstDetail
	 * @return string
	 */
    public function statusDetail($statusId, bool $showFirstDetail = FALSE) : array
    {
        $entryCriteria = 'MAX';
        if($showFirstDetail)
		{
			$entryCriteria = 'MIN';
		}
        $sql = "
        select 
			id_psl,
			project_id_psl,
			status_id_psl,	
			filter.entry_date,
			GROUP_CONCAT(CONCAT(responsible.id_usr)) responsible_user_id,
			GROUP_CONCAT(CONCAT(responsible.firstname_usr,' ',responsible.lastname_usr)) responsible,
			GROUP_CONCAT(CONCAT(builder.builder_id)) builder_responsible_id,
			GROUP_CONCAT(CONCAT(builder.builder_firstname,' ',builder.builder_lastname)) builder_responsible,
			-- fiscal.fiscal_id fiscal_responsible_id,
			GROUP_CONCAT(CONCAT(fiscal.fiscal_id)) fiscal_responsible_id,
			GROUP_CONCAT(CONCAT(fiscal.fiscal_firstname,' ',fiscal.fiscal_lastname)) fiscal_responsible,
			design_prb,
			building_prb,			
			transportation_prb,
			live_line_prb,
			right_of_way_prb,
            manpower_file_id_prb manpower_file_id,
			(IFNULL(design_prb,0) + IFNULL(building_prb,0) + IFNULL(transportation_prb,0) + IFNULL(live_line_prb,0) + IFNULL(right_of_way_prb,0)) as total_budget,
            tentative_total_budget_prb,
            reservation_number_prb,
            graph_number_prb,
            trim_tree_prb,
			design_reb,
			building_reb,			
			transportation_reb,
			live_line_reb,
			right_of_way_reb,
			(IFNULL(design_reb,0) + IFNULL(building_reb,0) + IFNULL(transportation_reb,0) + IFNULL(live_line_reb,0) + IFNULL(right_of_way_reb,0)) as total_real_budget,
			id_cas construction_assignment_id,
            start_date_cas,
			end_date_cas,
			estimated_time_cas,
			live_line_cas,
			power_down_cas,
			maneuver_cas,
            project_manager.id_usr project_manager_id,
            CONCAT(project_manager.firstname_usr,' ',project_manager.lastname_usr) project_manager_full_name,
			pauseOnIncident.percentage_inc percentage_paused,
			stopOnIncident.percentage_inc percentage_stopped,
			points_quantity_prp,
			distance_prp
		from 
			wfl_project_status_log
		RIGHT JOIN(
            SELECT			
                project_id_psl project_id,
                {$entryCriteria}(manual_entry_date_psl) as 'entry_date'
            FROM
                wfl_project_status_log
            WHERE		
            status_id_psl = ".$statusId." and project_id_psl = ".$this->id_pro."
            and deleted_psl != 1
            
            GROUP BY project_id_psl
		) as filter on filter.entry_date = manual_entry_date_psl and filter.project_id = project_id_psl
		LEFT JOIN wfl_projects on id_pro = project_id_psl
		LEFT JOIN (
                    select 
                        wfl_incidents.* 
                    from 
                        wfl_incidents
                    RIGHT JOIN 
                    (
                        SELECT
                            project_id_inc project_id,
                            MAX(manual_entry_date_inc) AS entry_date
                        FROM
                            wfl_incidents
                        where 
                            paused_inc = 1
                        and deleted_inc != 1 and project_id_inc = ".$this->id_pro."
                        GROUP BY
                            project_id_inc
                    ) last_incidents on last_incidents.project_id = project_id_inc and last_incidents.entry_date = manual_entry_date_inc
                ) pauseOnIncident on pauseOnIncident.project_id_inc = id_pro
        LEFT JOIN (
            select 
                wfl_incidents.* 
            from 
                wfl_incidents
            RIGHT JOIN 
            (
                SELECT
                    project_id_inc project_id,
                    MAX(manual_entry_date_inc) AS entry_date
                FROM
                    wfl_incidents
                where 
                    stopped_inc = 1
                and deleted_inc != 1 and project_id_inc = ".$this->id_pro."
                GROUP BY
                    project_id_inc
            ) last_incidents on last_incidents.project_id = project_id_inc and last_incidents.entry_date = manual_entry_date_inc
        ) stopOnIncident on stopOnIncident.project_id_inc = id_pro
		LEFT JOIN wfl_status_log_responsibles on wfl_status_log_responsibles.status_log_id_slr = id_psl
		LEFT JOIN wfl_status_responsibles on responsible_id_slr = id_sre		
		LEFT JOIN sec_users responsible on user_id_sre = responsible.id_usr
		LEFT JOIN (
                SELECT
                    id_usr builder_id,
                    firstname_usr builder_firstname,
                    lastname_usr builder_lastname
                FROM
                    sec_users
                right JOIN sec_userroles on userid_uro = id_usr
                where 
                    roleid_uro = 9
                and deleted_uro != 1
            ) as builder on builder.builder_id = user_id_sre
		LEFT JOIN (
                SELECT
                    id_usr fiscal_id,
                    firstname_usr fiscal_firstname,
                    lastname_usr fiscal_lastname
                FROM
                    sec_users
                right JOIN sec_userroles on userid_uro = id_usr
                where 
                    roleid_uro = 8
                and deleted_uro != 1
            ) as fiscal on fiscal.fiscal_id = user_id_sre		
		LEFT JOIN wfl_project_budgets on status_log_id_prb = id_psl
		LEFT JOIN wfl_project_real_budgets on status_log_id_reb = id_psl
		LEFT JOIN wfl_construction_assignments on status_log_id_cas = id_psl
		left join wfl_project_points on status_log_id_prp = id_psl
        left join sec_users project_manager on project_manager_cas = project_manager.id_usr
		where deleted_pro != 1 and deleted_slr != 1 and id_pro = ".$this->id_pro."
		GROUP BY id_psl
        ";

        $response = DB::select($sql);
        if(count($response) > 0)
        {
            $response = (array)$response[0];
        }
        return $response;
    }

    /**
     * Query complement
	 * @param $statusId
	 * @return string
	 */
	public static function paymentOrderStatusDetailQuery($statusId) : string
	{
		$sql = "
		select 
			id_pos,
            order_number_pao,
            filter.entry_date,
			project_id_pop,
            design_budget_pop,
            transportation_budget_pop,
            live_line_budget_pop,
			building_budget_pop,
            right_of_way_budget_pop,
            ifnull(design_budget_pop, 0) + ifnull(transportation_budget_pop, 0) + ifnull(live_line_budget_pop,0) + ifnull(building_budget_pop, 0) + ifnull(right_of_way_budget_pop, 0) total_real_budget,
            invoice_number_pao,			
            log_detail_pos,
			payment_order_id_pos,
			status_id_pos,
            wfl_contracts.contract_number_con end_contract_number
			
		from 
			wfl_payment_orders_status_log
		RIGHT JOIN(
				SELECT			
					payment_order_id_pos payment_order_id,
					max(manual_entry_date_pos) entry_date
				FROM
					wfl_payment_orders_status_log
				WHERE		
				status_id_pos = ".$statusId."
				and deleted_pos != 1				
				GROUP BY payment_order_id_pos
		) as filter on filter.entry_date = manual_entry_date_pos and filter.payment_order_id = payment_order_id_pos
		LEFT JOIN wfl_payment_orders on id_pao = payment_order_id_pos		
        left join wfl_payment_orders_projects on order_id_pop = id_pao 
        left join wfl_contracts on id_con = end_contract_id_pao
		where 
			deleted_pao != 1
            and deleted_pop != 1
        ";
		return $sql;
	}

    public function system()
    {
        return $this->belongsTo(ProjectSystem::class, 'system_pro');
    }

    public function managementBy()
    {
        return $this->belongsTo(ProjectManagement::class, 'management_by_pro');
    }

    public function creFiscal()
    {
        return $this->belongsTo(User::class, 'cre_fiscal_pro');
    }

    public function paymentOrderStatusDetail(int $statusId) : array
    {
        $sql = "
        select 
			id_pos,
            order_number_pao,
            filter.entry_date,
			project_id_pop,
            design_budget_pop,
            transportation_budget_pop,
            live_line_budget_pop,
			building_budget_pop,
            right_of_way_budget_pop,
            ifnull(design_budget_pop, 0) + ifnull(transportation_budget_pop, 0) + ifnull(live_line_budget_pop,0) + ifnull(building_budget_pop, 0) + ifnull(right_of_way_budget_pop, 0) total_real_budget,
            invoice_number_pao,			
            log_detail_pos,
			payment_order_id_pos,
			status_id_pos,
            wfl_contracts.contract_number_con end_contract_number
			
		from 
			wfl_payment_orders_status_log
		RIGHT JOIN(
				SELECT			
					payment_order_id_pos payment_order_id,
					max(manual_entry_date_pos) entry_date
				FROM
					wfl_payment_orders_status_log
				WHERE		
				status_id_pos = ".$statusId."
				and deleted_pos != 1				
				GROUP BY payment_order_id_pos
		) as filter on filter.entry_date = manual_entry_date_pos and filter.payment_order_id = payment_order_id_pos
		LEFT JOIN wfl_payment_orders on id_pao = payment_order_id_pos		
        left join wfl_payment_orders_projects on order_id_pop = id_pao 
        left join wfl_contracts on id_con = end_contract_id_pao
		where 
			deleted_pao != 1
            and deleted_pop != 1
			and project_id_pop = ".$this->id_pro.";
        ";
        $response = DB::select($sql);
        if(count($response) > 0)
        {
            $response = (array)$response[0];
        }
        return $response;
    }
    
    public function getProductionPercentageAttribute()
    {
        $statusKeyword = $this->status->keyword_pst;
        if(in_array($statusKeyword,['project_has_been_created','drawing','stakes','digitization','returned','schedule','ready_to_send','already_sent','rectify_design','rectify_illustration','rd_stakes','rd_digitization','rd_drawing','ri_digitization','ri_drawing','canceled']))
        {
            $totalProductionWithDesign = 0;
        }
        elseif(in_array($statusKeyword,['approved','assign_to','in_progress','paused','stopped','completed','project_energized','as_built']))
        {
            $totalProductionWithDesign = (($this->currentDesignBudget + $this->productionAmount) * 100) / $this->currentBudget;
        }
        elseif(in_array($statusKeyword,['conciliation_reception','conciliation_shipment','cre_return_order','project_return_materials','project_real_budget_confirmation']))
        {
            $paymentOrderRegistered = $this->paymentOrderStatusDetail(42);
            $conciliationReception = $this->statusDetail(34);

            $design = $conciliationReception['design_reb']??0;
            $totalRealBudget = $conciliationReception['total_real_budget']??0;
            if(isset($paymentOrderRegistered['order_number_pao']) && $paymentOrderRegistered['order_number_pao'] != '')
            {
                $design = $paymentOrderRegistered['design_budget_pop'];
                $totalRealBudget = $paymentOrderRegistered['total_real_budget'];
            }

            $totalProductionWithDesign = (($this->productionAmount + $design) * 100) / $totalRealBudget;
        }
        
        return  round($totalProductionWithDesign,2);   
    }

    public function getProductionAmountAttribute()
    {
        $sql = '
            SELECT
                project_id_lad,
                sum(ROUND(worked_up_wus * price_wus,2)) total_bs
            FROM
                bui_worked_up_structures
            LEFT JOIN bui_labor_cost on id_lac = labor_cost_id_wus
            LEFT JOIN bui_building_structures on building_structure_id_lac = id_bus
            LEFT JOIN bui_labor_details on id_lad = labor_detail_id_lac
            LEFT JOIN bui_labor_cost_log on id_lal = labor_cost_log_id_wus
            LEFT JOIN bui_building_points on point_id_lal = id_bpo
            where
                deleted_wus != 1
                and deleted_lal != 1 
                and project_id_lad = '.$this->id_pro.'
                and status_id_lad = 11
            GROUP BY project_id_lad;
        ';
        $response = DB::select($sql)[0]->total_bs??0;
        return $response;
    }

    public function moveToStatus($statusKeyword, $data)
    {
        $status = ProjectStatus::where('keyword_pst', $statusKeyword)->first();
        $this->status_pro = $status->id_pst;
        $this->save();
        $this->addStatusToLog();
    }

    public function addStatusToLog($statusId, $detail = "", $manualEntryDate = "", $responsibleList = array(), $fileIds = array()) : void
    {
        //Lets create a new log
        // $projectStatus = new Model_project_status_log($this->_id, $statusId, $detail, $manualEntryDate);
        // $projectStatus->save();
        //Updating project
        $this->status_pro = $statusId;
        $this->save();
        //Saving log
        $projectStatusLog = new ProjectStatusLog;
        $projectStatusLog->status_id_psl = $statusId;
        $projectStatusLog->project_id_psl = $this->id_pro;
        $projectStatusLog->manual_entry_date_psl = $manualEntryDate;
        $projectStatusLog->save();
        //Each statusLog needs to have one or more responsible by log
        // Model_status_log_responsible::addResponsible($projectStatus->getId(), $responsibleList);
        //If there is file ids added to status log, then let's save these
        // Model_project_status_file::addFiles($projectStatus->getId(), $fileIds, $this->_id, $statusId);
    }

    public function getCurrentBudgetAttribute()
    {
        $budget = 0;
        switch ($this->status->keyword_pst) 
        {
            case 'project_has_been_created':
            case 'drawing':
            case 'stakes':
            case 'digitization':
            case 'returned':
                $budget = $this->initial_design_budget_pro + $this->initial_building_budget_pro;
                break;
            case 'schedule':
            case 'ready_to_send':
            case 'already_sent':
            case 'rectify_design':
            case 'rectify_illustration':
            case 'rd_stakes':
            case 'rd_digitization':
            case 'rd_drawing':
            case 'ri_digitization':
            case 'ri_drawing':
                $schedule = $this->statusLog->where('status_id_psl',6)->first();
                if(is_null($schedule->projectBudget))
                {
                    $budget = 0;
                }
                else
                {
                    $budget = !is_null($schedule->projectBudget->tentative_total_budget_prb) && $schedule->projectBudget->tentative_total_budget_prb > 0?$schedule->projectBudget->tentative_total_budget_prb:$schedule->projectBudget->design_prb;
                }
                break;
            case 'canceled':
                $canceled = $this->statusLog->where('status_id_psl',12)->first();
                if(is_null($canceled->projectBudget))
                {
                    $budget = 0;
                }
                else
                {
                    $budget = $canceled->projectBudget->design_prb;
                }
                break;
                case 'approved': 
                case 'assign_to': 
                case 'in_progress': 
                case 'paused': 
                case 'stopped': 
                case 'completed': 
                case 'project_energized': 
                case 'as_built':
                    $approved = $this->statusLog->where('status_id_psl',11)->first();
                    if(is_null($approved) || is_null($approved->projectBudget))
                    {
                        $budget = 0;
                    }
                    else
                    {
                        $budget = $approved->projectBudget->design_prb + $approved->projectBudget->building_prb + $approved->projectBudget->transportation_prb + $approved->projectBudget->live_line_prb + $approved->projectBudget->right_of_way_prb;
                    }
                break;
                case 'conciliation_reception': 
                case 'conciliation_shipment': 
                case 'cre_return_order': 
                case 'project_return_materials':
                case 'project_real_budget_confirmation':
                    if($this->paymentOrderProject)
                    {
                        $budget = $this->paymentOrderProject->design_budget_pop + 
                                    $this->paymentOrderProject->transportation_budget_pop +
                                    $this->paymentOrderProject->live_line_budget_pop +
                                    $this->paymentOrderProject->building_budget_pop +
                                    $this->paymentOrderProject->right_of_way_budget_pop +
                                    $this->paymentOrderProject->total_real_budget;
                    }
                    else
                    {
                        $conciliationReception = $this->statusLog->where('status_id_psl',34)->first();
                        // dd($conciliationReception);
                        if ($conciliationReception->projectRealBudget) 
                        {
                            $budget = $conciliationReception->projectRealBudget->design_reb + 
                                    $conciliationReception->projectRealBudget->building_reb + 
                                    $conciliationReception->projectRealBudget->transportation_reb + 
                                    $conciliationReception->projectRealBudget->live_line_reb + 
                                    $conciliationReception->projectRealBudget->right_of_way_reb;
                        }
                        

                    }
                break;
            default:
                $budget = 0;
                break;
        }
        return $budget;
    }

    public function getCurrentDesignBudgetAttribute()
    {
        $budget = 0;
        switch ($this->status->keyword_pst) 
        {
            case 'project_has_been_created':
            case 'drawing':
            case 'stakes':
            case 'digitization':
            case 'returned':
                $budget = $this->initial_design_budget_pro;
                break;
            case 'schedule':
            case 'ready_to_send':
            case 'already_sent':
            case 'rectify_design':
            case 'rectify_illustration':
            case 'rd_stakes':
            case 'rd_digitization':
            case 'rd_drawing':
            case 'ri_digitization':
            case 'ri_drawing':
                $schedule = $this->statusLog->where('status_id_psl',6)->first();
                if(is_null($schedule->projectBudget))
                {
                    $budget = 0;
                }
                else
                {
                    $budget = !is_null($schedule->projectBudget->tentative_total_budget_prb) && $schedule->projectBudget->tentative_total_budget_prb > 0?$schedule->projectBudget->tentative_total_budget_prb:$schedule->projectBudget->design_prb;
                }
                break;
            case 'canceled':
                $canceled = $this->statusLog->where('status_id_psl',12)->first();
                if(is_null($canceled->projectBudget))
                {
                    $budget = 0;
                }
                else
                {
                    $budget = $canceled->projectBudget->design_prb;
                }
                break;
                case 'approved': 
                case 'assign_to': 
                case 'in_progress': 
                case 'paused': 
                case 'stopped': 
                case 'completed': 
                case 'project_energized': 
                case 'as_built':
                    $approved = $this->statusLog->where('status_id_psl',11)->first();
                    if(is_null($approved) || is_null($approved->projectBudget))
                    {
                        $budget = 0;
                    }
                    else
                    {
                        $budget = $approved->projectBudget->design_prb;
                    }
                break;
                case 'conciliation_reception': 
                case 'conciliation_shipment': 
                case 'cre_return_order': 
                case 'project_return_materials':
                case 'project_real_budget_confirmation':
                    if($this->paymentOrderProject)
                    {
                        $budget = $this->paymentOrderProject->design_budget_pop + $this->paymentOrderProject->total_real_budget;
                    }
                    else
                    {
                        $conciliationReception = $this->statusLog->where('status_id_psl', 34)->first();
                        if ($conciliationReception->projectRealBudget) 
                        {
                            $budget = $conciliationReception->projectRealBudget->design_reb;
                        }
                    }
                break;
            default:
                $budget = 0;
                break;
        }
        return $budget;
    }

    public function getCurrentStatusLogAttribute()
    {
        $currentStatusData = $this->statusLog->where('status_id_psl',$this->status_pro)->first();
        return $currentStatusData;
    }

    public function paymentOrderProject()
    {
        return $this->hasOne(PaymentOrderProject::class, 'project_id_pop');
    }

    /**
	 * Save the points to log.
	 * @param $points
	 * @param $metersDistance
	 * @param $statusId
	 * @param $statusDetail
	 * @param $manualEntryDate
	 * @param array $responsibleList
	 * @param array $fileIds
	 */
	public function savePoints($points, $metersDistance, $statusId, $statusDetail, $manualEntryDate, $responsibleList = array(), $fileIds = array()) : void
    {
        //Lets create a new log
        $projectStatusLogData = [
            'project_id_psl' => $this->id_pro, 
            'status_id_psl' => $statusId,
            'log_detail_psl' => $statusDetail,
            'manual_entry_date_psl' => $manualEntryDate
        ];

        $projectStatus = ProjectStatusLog::create($projectStatusLogData);

        //Create the record about the points and distance and associate it to project status log
        $projectPointsData = [
            '' => $projectStatus->getId(),
            '' => $points,
            '' => $metersDistance
        ];
        // $projectPoints =  new Model_project_points();
        // $projectPoints->save();

        //Each statusLog needs to have a o more responsible by log
        Model_status_log_responsible::addResponsible($projectStatus->getId(), $responsibleList);

        //If there is file ids added to status log, then let's save these        
        Model_project_status_file::addFiles($projectStatus->getId(), $fileIds, $this->_id, $statusId);
    }
}
