<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Avatar;
use App\Models\Badge;
use App\Models\Challenge;
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
        $challenge = new Challenge();
        $challenge->name = 'Challenge 1';
        $challenge->description = 'Description of challenge 1';
        $challenge->startAt = now();
        $challenge->endAt = now()->addDays(7);
        $challenge->allSteps = 0;
        $challenge->password = 'password';
        $challenge->save();

        Job::factory(10)->create();
        Badge::factory(5)->create();
        Avatar::factory(10)->create();
        User::factory(10)->create();
    }
}
