<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'assigned_to',
        'thumbnail',
        'due_date',
    ];

    public function getAssignedToArrayAttribute()
    {
        return $this->assigned_to ? explode(',', $this->assigned_to) : [];
    }
}
