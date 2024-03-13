<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Challenge;
use App\Models\DailyChallengeStep;
use App\Models\HealthMessage;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $currentChallenge = Challenge::where('endAt','>',(new DateTime())->setTime(0,0))->first();
        $steps = DailyChallengeStep::where('challengeId','=',$currentChallenge->id)->orderBy('day')->get();
        $monthSteps = DailyChallengeStep::where([
            ['day','>=',(new DateTime())->sub(DateInterval::createFromDateString('30 days'))],
            ['challengeId','=',$currentChallenge->id]
            ]);
        $weekSteps = DailyChallengeStep::where([
            ['day','>=',(new DateTime())->sub(DateInterval::createFromDateString('7 days'))],
            ['challengeId','=',$currentChallenge->id]
        ]);
        return [
            'totalSteps' => $currentChallenge->allSteps,
            'challengeSteps' => $steps,
            'totalMonthSteps' => $monthSteps->sum('stepCount'),
            'monthSteps' => $monthSteps->orderBy('day')->get(),
            'totalWeekSteps' => $weekSteps->sum('stepCount'),
            'weekSteps' => $weekSteps->orderBy('day')->get(),
        ];
    }
}
