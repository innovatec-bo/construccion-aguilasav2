<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ProjectBudget;

class TreePruningIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $projectCode = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $budgets = ProjectBudget::query()
            ->where('trim_tree_prb', 1)
            ->whereHas('projectStatusLog')
            ->with(['project', 'treePruning'])
            ->when($this->projectCode, function ($query) {
                $query->whereHas('project', function ($q) {
                    $q->where('code_pro', 'like', '%' . $this->projectCode . '%');
                });
            })
            ->orderByDesc('id_prb')
            ->paginate(10);

        return view('livewire.admin.tree-pruning-index', compact('budgets'));
    }
}