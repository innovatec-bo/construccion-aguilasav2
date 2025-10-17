<?php

namespace App\Livewire\Admin;

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
    public $species;
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
        $this->species = 1;//Desconocida
        $this->projectBudget = $projectBudget;
    }

    public function render()
    {
        return view('livewire.admin.tree-pruning-create');
    }

    public function rules()
    {
        return [
            'treeNumber'   => ['required', 'integer', 'min:1'],
            'species'      => ['required', 'exists:tree_species,id'],
            'utmX'         => ['required', 'numeric'],
            'utmY'         => ['required', 'numeric'],
            'neighborhood' => ['required', 'string', 'max:255'],
            'neighborhoodUnit' => ['required', 'string', 'max:255'],
            'block'        => ['required', 'string', 'max:100'],
            'district'     => ['required', 'string', 'max:255'],
            'quality'      => ['required', 'string', 'max:20'],
            'pruningType'  => ['required', 'string', 'max:50'],
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
        $data = [
            'budget_id' => $this->projectBudget->id_prb,
            'tree_number' => $this->treeNumber,
            'species_id' => $this->species,
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
            if ($contents === false) throw new \Exception("Can't read $url registering ecommerce ".$model->ecommerce_name);

            $image = $manager->read($contents);
            $image->scale(720, 720);
            $stream = $image->toJpeg();

            $time = Carbon::now()->timestamp;
            $model
                ->addMediaFromStream($stream)
                ->usingFileName($filenamePrefix . '_' . $time . '.jpg')
                ->toMediaCollection($collection);
        } catch (\Throwable $e) {
            Log::error("Error processing file for $collection to tree_pruning ".$model->ecommerce_name, [
                'error' => $e->getMessage(),
                'tree_pruning_id' => $model->id,
                'url' => $url
            ]);
        }
    }
}
