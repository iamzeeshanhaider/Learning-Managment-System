<?php

namespace Database\Factories;

use App\Enums\GeneralStatus;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CourseMaster>
 */
class CourseMasterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->randomElement(['Financial Accounting', 'Cost Accounting', 'Management Accounting', 'Corporate Finance', 'Book Keeping']),
            'description' => $this->faker->paragraph(),
            'status' => $this->faker->randomElement([GeneralStatus::Enabled, GeneralStatus::Disabled]),
            'category_id' => Category::query()->inRandomOrder()->firstOrFail()->id,
        ];

    }
}
