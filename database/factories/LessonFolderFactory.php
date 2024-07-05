<?php

namespace Database\Factories;

use App\Models\Lesson;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LessonFolder>
 */
class LessonFolderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'slug' => $this->faker->slug,
            'is_published' => $this->faker->randomElement([1, 0]),
            'lesson_id' => Lesson::query()->inRandomOrder()->firstOrFail()->id,
        ];
    }
}
