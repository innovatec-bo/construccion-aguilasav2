<?php

namespace App\Models;

use AppKit\Blameable\Traits\Blameable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Blameable;
    
    protected $table = "wfl_projects";
    protected $primaryKey = "id_pro";

    const CREATED_AT = 'createdon_pro';
    const UPDATED_AT = 'editedon_pro';

    protected $casts = [
        'entry_date_pro' => 'datetime'
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
        return $this->hasMany(ProjectStatusLog::class, 'project_id_psl');
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
	 * This method is a complement of getWorkflowDetail method.
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
			status_id_pos
			
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
}
