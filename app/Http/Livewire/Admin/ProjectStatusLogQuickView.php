<?php

namespace App\Http\Livewire\Admin;

use App\Models\ProjectStatusLog;
// use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class ProjectStatusLogQuickView extends Component
{
    public $logs;
    public $pageNumber = 1;
    public $hasMorePages;

    public function mount()
    {
        $this->logs = new Collection();
        $this->loadLogs();
    }

    public function loadLogs()
    {
        $logs = ProjectStatusLog::orderBy('manual_entry_date_psl', 'desc')->paginate(5, ['*'], 'page', $this->pageNumber);

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
