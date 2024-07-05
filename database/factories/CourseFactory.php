<?php

namespace Database\Factories;

use App\Enums\GeneralStatus;
use App\Models\{CourseMaster, User, Location, Module};
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->unique()->randomElement(['Financial Accounting 101', 'Introduction to Accounting', 'Getting started with Management Accounting', 'Basics of Corporate Finance', 'Introduction to Book Keeping']),
            'code' => hexdec(uniqid()),
            'price' => $this->faker->numberBetween(0, 1000),
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->date(),
            'status' => $this->faker->randomElement([GeneralStatus::Enabled, GeneralStatus::Disabled]),
            'location_id' => Location::query()->inRandomOrder()->firstOrFail()->id,
            'course_master_id' => CourseMaster::query()->inRandomOrder()->firstOrFail()->id,
            'instructor_id' => User::query()->inRandomOrder()->firstOrFail()->id,
            'module_id' => Module::query()->inRandomOrder()->firstOrFail()->id,
            'image' => ''
        ];
    }

}
