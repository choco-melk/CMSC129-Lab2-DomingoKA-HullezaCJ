<?php

namespace Database\Seeders;

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

        // Seed 15 active projects
        Project::factory(15)->create();

        // Seed 3 already-trashed projects (for demo purposes)
        Project::factory(3)->create()->each(function ($project) {
            $project->delete();
        });
    }
}