<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use RichanFongdasen\EloquentBlameable\BlameableTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class TreePruning extends Model implements HasMedia
{
    use HasFactory;
    use SoftDeletes;
    use BlameableTrait;
    use InteractsWithMedia;

    protected $fillable = [
        'budget_id',
        'tree_number',
        'species_id',
        'utm_x',
        'utm_y',
        'neighborhood',
        'neighborhood_unit',
        'block',
        'district',
        'quality',
        'pruning_type',
        'has_agreement',
        'notes',
        'pruned_at',
    ];

    protected $casts = [
        'has_agreement' => 'boolean',
        'pruned_at' => 'date',
    ];

    public function budget()
    {
        return $this->belongsTo(ProjectBudget::class);
    }

    public function specy()
    {
        return $this->belongsTo(TreeSpecies::class, 'species_id');
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('before')
            ->useFallbackUrl(asset('images/no-picture-available.jpg'))
            ->useFallbackPath(public_path('images/no-picture-available.jpg'))
            ->singleFile();
        
        $this
            ->addMediaCollection('after')
            ->useFallbackUrl(asset('images/no-picture-available.jpg'))
            ->useFallbackPath(public_path('images/no-picture-available.jpg'))
            ->singleFile();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('md')
              ->width(480)
              ->height(480)
              ->sharpen(10)
              ->keepOriginalImageFormat()
              ->nonQueued();

        $this->addMediaConversion('sm')
              ->width(240)
              ->height(240)
              ->sharpen(10)
              ->keepOriginalImageFormat()
              ->nonQueued();

        $this->addMediaConversion('blurred')
              ->width(480)
              ->height(480)
              ->blur(50)
              ->keepOriginalImageFormat()
              ->nonQueued();
    }
}
