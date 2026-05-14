<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'assigned_to',
        'thumbnail',
        'due_date',
    ];

    public function getAssignedToArrayAttribute(): array
    {
        return $this->assigned_to ? explode(',', $this->assigned_to) : [];
    }
}