<?php

namespace Database\Factories;

use App\Models\Challenge;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DailyChallengeStep>
 */
class DailyChallengeStepFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'stepCount'=> $this->faker->numberBetween(1000,15000),
            'day' => $this->faker->dateTimeBetween('-10 days', '+10 days'),
            'challengeId' => Challenge::all()->random()->first()->id,
        ];
    }
}
