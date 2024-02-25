<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Avatar;
use App\Models\Badge;
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
        // Creating the challenges, badges, avatars, etc, before  creating the users for the constraints

        // create a challenge
        $challenge = new \App\Models\Challenge();
        $challenge->name = 'Challenge 1';
        $challenge->description = 'Description of challenge 1';
        $challenge->startAt = now();
        $challenge->endAt = now()->addDays(7);
        $challenge->allSteps = 0;
        $challenge->password = 'password';
        $challenge->save();

        // create a badge
        $badge = new \App\Models\Badge();
        $badge->name = 'Badge 1';
        $badge->description = 'Description of badge 1';
        $badge->image = 'badge1.png';
        $badge->save();

        // create an avatar
        $avatar = new \App\Models\Avatar();
        $avatar->name = 'Avatar 1';
        $avatar->image = 'avatar1.png';
        $avatar->badgeId = $badge->id;
        $avatar->save();

        // create a job
        $job = new \App\Models\Job();
        $job->name = 'Job 1';
        $job->save();

        // create a user with a random code and password
        $user = new \App\Models\User();
        $user->avatarId = $avatar->id;
        $user->age = 0;
        $user->sexe = 'N/A';
        $user->jobId = $job->id;
        $user->shareData = true;
        $user->isAdmin = true;
        $user->code = '123456789';
        $user->password = bcrypt('password');
        $user->save();
       // Job::factory(10)->create();
       // Badge::factory(5)->create();
       // Avatar::factory(10)->create();
       // User::factory(10)->create();
    }
}