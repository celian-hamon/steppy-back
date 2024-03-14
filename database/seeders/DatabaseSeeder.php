<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Avatar;
use App\Models\Badge;
use App\Models\Challenge;
use App\Models\DailyChallengeStep;
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

        // Badge::factory(5)->create();
        Avatar::factory(10)->create();
        User::factory(10)->create();

        $user = User::factory()->create([
            'code' => '123456789',
            'isAdmin' => true,
            'password' => bcrypt('password')
        ]);

        $user = User::factory()->create([
            'code' => '987654321',
            'isAdmin' => false,
            'password' => bcrypt('password')
        ]);

        $this->createBadges();

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

    private function createBadges()
    {
        $badgesData = [
            ['image' => 'image1.png', 'name' => 'Premiers pas', 'description' => 'Faire ses premiers pas', 'isGlobal' => false, 'isStreak' => false, 'quantity' => 100, 'avatarId' => 1],
            ['image' => 'image2.png', 'name' => 'Marcheur confirmé', 'description' => 'Faire 5000 pas, à moitié arrivé !', 'isGlobal' => false, 'isStreak' => false, 'quantity' => 5000, 'avatarId' => 2],
            ['image' => 'image5.png', 'name' => 'Rythme élevé', 'description' => 'Faites 7 500 pas !', 'isGlobal' => false, 'isStreak' => false, 'quantity' => 7500, 'avatarId' => 5],
            ['image' => 'image9.png', 'name' => 'Escapade aérienne', 'description' => 'Faites 10 000 pas, vous êtes arrivé !', 'isGlobal' => false, 'isStreak' => false, 'quantity' => 10000, 'avatarId' => 9],
            ['image' => 'image4.png', 'name' => 'Randonneur', 'description' => 'Faites 15 000 pas. 15km à pieds, ca use, ca use !', 'isGlobal' => false, 'isStreak' => false, 'quantity' => 15000, 'avatarId' => 4],
            ['image' => 'image3.png', 'name' => 'Pas de géant', 'description' => 'Faites 100 000 pas !', 'isGlobal' => false, 'isStreak' => false, 'quantity' => 100000, 'avatarId' => 3],
            ['image' => 'image6.png', 'name' => 'Marathonien', 'description' => 'Parcours 42 000 pas', 'isGlobal' => false, 'isStreak' => false, 'quantity' => 42000, 'avatarId' => 6],
            ['image' => 'image7.png', 'name' => 'Explorateur', 'description' => 'Atteint les 500 000 pas !', 'isGlobal' => false, 'isStreak' => false, 'quantity' => 500000, 'avatarId' => 7],
            ['image' => 'image8.png', 'name' => 'Marche triomphale', 'description' => 'Atteint les 15 000 pas en un jour !', 'isGlobal' => false, 'isStreak' => false, 'quantity' => 15000, 'avatarId' => 8],
        ];
    
        foreach ($badgesData as $badgeData) {
            Badge::create($badgeData);
        }
    }
    
}
