<?php

namespace App\Http\Livewire\Admin;

use App\Models\ProjectStatusLog;
use Illuminate\Database\Eloquent\Builder;
// use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class ProjectStatusLogQuickView extends Component
{
    public $logs;
    public $pageNumber = 1;
    public $hasMorePages;
    public $project;
    public $hiddenStatus;

    public function mount()
    {
        $this->hiddenStatus = [
            'schedule',
            'approvement'
        ];
        $this->logs = new Collection();
        $this->loadLogs();
    }

    public function loadLogs()
    {
        $logs = ProjectStatusLog::whereHas('status', function(Builder $query){
            $query->whereNotIn('keyword_pst',$this->hiddenStatus);
        })
        ->where('project_id_psl', $this->project->id_pro)->orderBy('manual_entry_date_psl', 'desc')->paginate(5, ['*'], 'page', $this->pageNumber);

        $this->pageNumber += 1;

        $this->hasMorePages = $logs->hasMorePages();

        $this->logs->push(...$logs->items());
        // dd($this->logs);
    }

    public function render()
    {
        return view('livewire.admin.project-status-log-quick-view');
    }


}
