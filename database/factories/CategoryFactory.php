<?php

namespace Database\Factories;

use App\Enums\GeneralStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->randomElement(['Accounting', 'Finance']),
            'description' => $this->faker->paragraph(),
            'status' => $this->faker->randomElement([GeneralStatus::Enabled, GeneralStatus::Disabled]),
            'image' => ''
        ];
    }
}
