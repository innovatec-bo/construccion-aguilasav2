<?php

namespace App\Livewire\Admin;

use App\Enums\PruningType;
use App\Models\ProjectBudget;
use App\Models\TreePruning;
use App\Models\TreeSpecies;
use Carbon\Carbon;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Illuminate\Support\Facades\Log;

class TreePruningCreate extends Component
{
    use WithFileUploads;

    public $projectBudget;
    #[Validate(as: 'nro de arbol')]
    public $treeNumber;
    public $speciesId;
    #[Validate(as: 'Coordinate UTM X')]
    public $utmX;
    #[Validate(as: 'Coordinate UTM Y')]
    public $utmY;
    #[Validate(as: 'barrio')]
    public $neighborhood;
    #[Validate(as: 'unidad vecinal')]
    public $neighborhoodUnit;
    #[Validate(as: 'manzano')]
    public $block;
    #[Validate(as: 'distrito')]
    public $district;
    #[Validate(as: 'calidad')]
    public $quality;
    #[Validate(as: 'tipo de poda')]
    public $pruningType;
    public $pruningTypeList;
    #[Validate(as: 'con convenio')]
    public $hasAgreement;
    public $notes;
    #[Validate(as: 'fecha de poda')]
    public $prunedAt;
    #[Validate(as: 'antes')]
    public $before;
    public $temporaryBeforeUrl;
    #[Validate(as: 'despues')]
    public $after;
    public $temporaryAfterUrl;
    
    public $treeSpeciesList;

    public function mount(ProjectBudget $projectBudget)
    {
        $this->treeSpeciesList = TreeSpecies::all();
        $this->projectBudget = $projectBudget;
        $this->pruningTypeList = [
            PruningType::FORMATION_OR_DIRECTED->value => PruningType::FORMATION_OR_DIRECTED->label(),
            PruningType::ORNAMENTAL->value => PruningType::ORNAMENTAL->label(),
            PruningType::THINNING->value => PruningType::THINNING->label(),
            PruningType::FLOWERING->value => PruningType::FLOWERING->label(),
            PruningType::REGENERATION_OR_RIGOROUS->value => PruningType::REGENERATION_OR_RIGOROUS->label(),
            PruningType::BALANCED->value => PruningType::BALANCED->label(),
            PruningType::SANITARY->value => PruningType::SANITARY->label(),
            PruningType::EMERGENCY->value => PruningType::EMERGENCY->label()
        ];
    }

    public function render()
    {
        return view('livewire.admin.tree-pruning-create');
    }

    public function rules()
    {
        return [
            'treeNumber'   => ['required', 'integer', 'min:1'],
            // 'speciesId'      => ['required', 'exists:tree_species,id'],
            'utmX'         => ['required', 'numeric'],
            'utmY'         => ['required', 'numeric'],
            'neighborhood' => ['required', 'string', 'max:255'],
            'neighborhoodUnit' => ['required', 'string', 'max:255'],
            'block'        => ['required', 'string', 'max:100'],
            'district'     => ['required', 'string', 'max:255'],
            'quality'      => ['required', 'string', 'max:20'],
            'pruningType'  => ['required'],
            'hasAgreement' => ['required', 'boolean'],
            'prunedAt'     => ['required', 'date_format:d/m/Y'],
            'before'       => ['nullable', 'image', 'max:5120', 'mimes:jpg,jpeg,png,webp'],
            'after'        => ['nullable', 'image', 'max:5120', 'mimes:jpg,jpeg,png,webp'],
        ];
    }

    public function save()
    {
        $this->validate();

        $prunedAt = Carbon::createFromFormat('d/m/Y', $this->prunedAt)->format('Y-m-d');
        if (!is_numeric($this->speciesId)) 
        {
            $species = TreeSpecies::create(['name' => $this->speciesId]);
            $this->speciesId = $species->id;
        }
        $data = [
            'budget_id' => $this->projectBudget->id_prb,
            'tree_number' => $this->treeNumber,
            'species_id' => $this->speciesId,
            'utm_x' => $this->utmX,
            'utm_y' => $this->utmY,
            'neighborhood' => $this->neighborhood,
            'neighborhood_unit' => $this->neighborhoodUnit,
            'block' => $this->block,
            'district' => $this->district,
            'quality' => $this->quality,
            'pruning_type' => $this->pruningType,
            'has_agreement' => $this->hasAgreement,
            'notes' => $this->notes,
            'pruned_at' => $prunedAt,
        ];

        $treePruning = TreePruning::create($data);

        if ($this->before) 
        {
            $this->_addImageToMediaCollection($treePruning, $this->temporaryBeforeUrl, 'tree_pruning_before', 'before');
        }

        if ($this->after) 
        {
            $this->_addImageToMediaCollection($treePruning, $this->temporaryAfterUrl, 'tree_pruning_after', 'after');
        }
        $this->dispatch('hideModal');
        $this->dispatch('tree-pruning-created');
    }

    public function updatedBefore()
    {
        if(is_array($this->before))
        {
            $this->before = $this->before[0];
        }
        $this->temporaryBeforeUrl = $this->before->temporaryUrl();
    }

    public function updatedAfter()
    {
        if(is_array($this->after))
        {
            $this->after = $this->after[0];
        }
        $this->temporaryAfterUrl = $this->after->temporaryUrl();
    }

    public function triggerLoading()
    {
        return 0;
    }

    private function _addImageToMediaCollection($model, $url, $filenamePrefix, $collection)
    {
        try {
            $manager = new ImageManager(new GdDriver());
            $contents = file_get_contents($url);
            if ($contents === false) throw new \Exception("Can't read $url registering treePruning ID ".$model->id);

            $image = $manager->read($contents);
            $image->scale(1024, 1024);
            $stream = $image->toJpeg();

            $time = Carbon::now()->timestamp;
            $model
                ->addMediaFromStream($stream)
                ->usingFileName($filenamePrefix . '_' . $time . '.jpg')
                ->toMediaCollection($collection);
        } catch (\Throwable $e) {
            Log::error("Error processing file for $collection to tree_pruning ID ".$model->id, [
                'error' => $e->getMessage(),
                'tree_pruning_id' => $model->id,
                'url' => $url
            ]);
        }
    }
}
