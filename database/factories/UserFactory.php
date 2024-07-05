<?php

namespace Database\Factories;

use App\Enums\Gender;
use App\Models\Country;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->firstName(),
            'lname' => $this->faker->lastName(),
            'phone' => $this->faker->phoneNumber(),
            'username' => $this->faker->userName(),
            'email' => $this->faker->unique()->safeEmail(),
            'designation' => $this->faker->jobTitle(),
            'dob' => $this->faker->date(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // password
            'remember_token' => Str::random(10),
            'gender' => $this->faker->randomElement([Gender::Male, Gender::Female, Gender::Others]),
            'country_id' => Country::query()->inRandomOrder()->firstOrFail()->id,
            'city' => $this->faker->city(),
            'address' => $this->faker->address(),
            'last_login' => now(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
