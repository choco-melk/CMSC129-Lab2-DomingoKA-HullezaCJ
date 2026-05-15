<?php

namespace Database\Seeders;

use App\Models\Collaborator;
use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $collaborators = collect(['Clyde', 'Jave', 'Keith', 'Neyro', 'Mark'])
            ->map(fn (string $name) => Collaborator::firstOrCreate(['name' => $name]));

        Project::factory(15)->create()->each(function (Project $project) use ($collaborators) {
            $assigned = $collaborators->random(rand(1, 3));
            $project->collaborators()->attach($assigned->pluck('id')->toArray());
            $project->assigned_to = $assigned->pluck('name')->implode(',');
            $project->save();
        });

        Project::factory(3)->create()->each(function (Project $project) use ($collaborators) {
            $assigned = $collaborators->random(rand(1, 2));
            $project->collaborators()->attach($assigned->pluck('id')->toArray());
            $project->assigned_to = $assigned->pluck('name')->implode(',');
            $project->save();
            $project->delete();
        });
    }
}
