<?php

namespace App\Console\Commands;

use App\Models\Challenge;
use App\Models\DailyChallengeStep;
use App\Models\DailyStep;
use DateTime;
use Illuminate\Console\Command;

class SyncData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = (new DateTime())->setTime(0, 0);
        $todayClause = [["day", ">=", $today]];

        $challenge = Challenge::where('endAt', '>', $today)->first();
        if (empty($challenge)) {
            return;
        }

        $globalStep = DailyChallengeStep::where($todayClause)->first();

        if (empty($globalStep)) {
            dump('test');
            $globalStep = new DailyChallengeStep();
            $globalStep->day = $today;
            $globalStep->stepCount = 0;
            $globalStep->challengeId = $challenge->id;
            $globalStep->save();
        }

        $globalStep->stepCount = DailyStep::where($todayClause)->sum('stepCount');
        $globalStep->save();
        $challenge->allSteps = DailyChallengeStep::where('challengeId', '=', $challenge->id)
            ->sum('stepCount');
        $challenge->save();
    }
}
