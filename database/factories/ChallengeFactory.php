<?php

namespace Database\Factories;

use App\Models\DailyStep;
use DateInterval;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Challenge>
 */
class ChallengeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $interval = DateInterval::createFromDateString('30 day');

        return [
            'name' => $this->faker->name,
            'startAt' => (new \DateTime())->sub($interval),
            'endAt' => (new \DateTime())->add($interval),
            'password' => $this->faker->name,
            'allSteps' => 4000000,
            'description' => $this->faker->sentence,
        ];
    }
}
