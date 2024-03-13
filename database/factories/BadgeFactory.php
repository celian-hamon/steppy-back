<?php

namespace Database\Factories;

use App\Models\Avatar;
use App\Models\Badge;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Badge>
 */
class BadgeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $isStreak = $this->faker->boolean();
        return [
            'image' => "placeholder.png",
            'name' => $this->faker->name(),
            'description' => $this->faker->sentence(),
            'isStreak' => $isStreak,
            'quantity' => $isStreak ? $this->faker->numberBetween(1, 100) : $this->faker->numberBetween(1000, 30000),
            'isGlobal' => $this->faker->boolean(),
            'avatarId' => Avatar::factory()
        ];
    }
}
