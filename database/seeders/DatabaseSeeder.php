<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Avatar;
use App\Models\Badge;
use App\Models\Challenge;
use App\Models\DailyChallengeStep;
use App\Models\DailyStep;
use App\Models\Job;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Challenge::factory(1)->create();
        DailyChallengeStep::factory(10)->create();

        Badge::factory(5)->create();
        Avatar::factory(10)->create();
        User::factory(10)->create();

        $user = User::factory()->create([
            'code' => '123456789',
            'isAdmin' => true,
            'password' => bcrypt('password')
        ]);

        // Create fake steps for past 10 days for all users including (and make them part of the challenge)
        $users = User::all();
        $challenge = Challenge::all()->random()->value('id');
        foreach ($users as $user) {
            $user->challenges()->attach($challenge);
            for ($i = 0; $i < 10; $i++) {
                $user->daily_steps()->create([
                    'stepCount' => rand(1000, 10000),
                    'day' => now()->subDays($i)
                ]);
            }
        }
    }
}
