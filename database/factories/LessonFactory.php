<?php

namespace Database\Factories;

use App\Enums\GeneralStatus;
use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lesson>
 */
class LessonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->randomElement([
                'Accounting Concepts', 'Double Entry', 'Basic Transactions', 'Financial Statement', 'Cash Flow',
                'Cost Principle', 'Income Statement', 'Revenue', 'Banks', 'Cash Flow Analysis',
            ]),
            'name' => $this->faker->unique()->name(),
            'outcome' => $this->faker->paragraph(),
            'status' => $this->faker->randomElement([GeneralStatus::Enabled, GeneralStatus::Disabled]),
            'course_id' => Course::query()->inRandomOrder()->firstOrFail()->id,
            'image' => '',
        ];
    }
}
