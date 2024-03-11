<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DailyStep;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DailyStepsController extends Controller
{
    /**
     * Retrieve all daily steps.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        return DailyStep::all();
    }


    /**
     * Store or update the daily steps for a user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeOrUpdate(Request $request)
    {
        $request->validate([
            'stepCount' => 'required|integer',
            'day' => 'date',
        ]);

        // If day is not provided in the request, use today's date
        $day = $request->day ? $request->day : now()->startOfDay();

        // Find or create a DailyStep for the provided day for the user
        $dailyStep = DailyStep::updateOrCreate(
            ['day' => $day, 'userId' => $request->user()->id],
            ['stepCount' => $request->stepCount]
        );

        return response()->json($dailyStep, Response::HTTP_CREATED);
    }

    /**
     * Display the daily step count for a specific date.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function showAtDate(Request $request)
    {
        $request->validate([
            'day' => 'required|date',
        ]);

        $dailyStep = DailyStep::where('day', $request->day)
                              ->where('userId', $request->user()->id)
                              ->first();

        if (!$dailyStep) {
            return response()->json(['message' => 'DailyStep not found for this date'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($dailyStep, Response::HTTP_OK);
    }

    
    /**
     * Retrieve the last recorded daily steps for the authenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function lastUserSteps(Request $request)
    {
        $dailyStep = DailyStep::where('userId', $request->user()->id)
                              ->orderBy('day', 'desc')
                              ->first();

        if ($dailyStep) {
            return response()->json($dailyStep, Response::HTTP_OK);
        } else {
            return response()->json(['message' => 'No daily steps found for this user'], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Update the daily step count for a specific date.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateAtDate(Request $request)
    {
        $request->validate([
            'stepCount' => 'required|integer',
            'day' => 'required|date',
        ]);

        $dailyStep = DailyStep::where('day', $request->day)
            ->where('userId', $request->user()->id)
            ->first();

        if (!$dailyStep) {
            return response()->json(['message' => 'DailyStep not found for this date'], Response::HTTP_NOT_FOUND);
        }

        $dailyStep->update($request->all());

        return response()->json($dailyStep, Response::HTTP_OK);
    }

    /**
     * Delete a daily step record.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $dailyStep = DailyStep::find($id);

        if (!$dailyStep) {
            return response()->json(['message' => 'DailyStep not found'], Response::HTTP_NOT_FOUND);
        }

        $dailyStep->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
