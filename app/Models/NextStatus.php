<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NextStatus extends Model
{
    use HasFactory;

    public function parentStatus()
    {
        return $this->belongsTo(ProjectStatus::class, 'parent_status_id');
    }

    public function nextStatus()
    {
        return $this->belongsTo(ProjectStatus::class, 'next_status_id');
    }
}
