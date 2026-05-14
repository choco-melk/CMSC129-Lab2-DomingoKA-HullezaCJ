<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    public function definition(): array
    {
        $collaborators = ['Clyde', 'Jave', 'Keith', 'Neyro', 'Mark'];

        $assigned = fake()->randomElements(
            $collaborators,
            fake()->numberBetween(1, 3)
        );

        return [
            'title'       => fake()->sentence(3, true),
            'description' => fake()->paragraph(2),
            'assigned_to' => implode(',', $assigned),
            'thumbnail'   => null,
            'due_date'    => fake()->optional(0.7)->dateTimeBetween('now', '+3 months')?->format('Y-m-d'),
            'status'      => fake()->randomElement(['active', 'in_progress', 'completed', 'on_hold']),
        ];
    }
}