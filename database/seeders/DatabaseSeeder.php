<?php

namespace Database\Seeders;

use App\Models\Collaborator;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::factory()->create([
            'name'  => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Seed collaborators
        $collaborators = collect(['Clyde', 'Jave', 'Keith', 'Neyro', 'Mark'])
            ->map(fn($name) => Collaborator::create(['name' => $name]));

        // Seed 15 active projects and attach random collaborators
        Project::factory(15)->create()->each(function ($project) use ($collaborators) {
            $project->collaborators()->attach(
                $collaborators->random(rand(1, 3))->pluck('id')
            );
        });

        // Seed 3 soft-deleted projects
        Project::factory(3)->create()->each(function ($project) use ($collaborators) {
            $project->collaborators()->attach(
                $collaborators->random(rand(1, 2))->pluck('id')
            );
            $project->delete();
        });
    }
}