<?php

namespace Database\Factories;

use App\Models\Avatar;
use App\Models\Job;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
    public function definition(): array
    {
        return [
            'id' => $this->faker->uuid(),
            'avatarId' => Avatar::all()->random()->first()->id,
            'age' => $this->faker->numberBetween(18, 60),
            'sexe' => $this->faker->randomElement(['f', 'm']),
            'jobId' => Job::all()->random()->first()->id,
            'shareData' => $this->faker->boolean(),
            'code' => $this->faker->uuid(),
            'lastLogin' => $this->faker->dateTime(),
            'isAdmin' => $this->faker->boolean(),
            'password' => Hash::make('password'),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
