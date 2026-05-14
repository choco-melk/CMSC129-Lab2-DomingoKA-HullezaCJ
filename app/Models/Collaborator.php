<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Collaborator extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email'];

    // A collaborator belongs to many projects
    public function projects()
    {
        return $this->belongsToMany(Project::class);
    }
}