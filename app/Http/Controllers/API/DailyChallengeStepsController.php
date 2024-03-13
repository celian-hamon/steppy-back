<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DailyChallengeStep;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DailyChallengeStepsController extends Controller
{
    /**
     * Retrieve all daily challenge steps.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        $dailyChallengeSteps = DailyChallengeStep::all();

        if ($dailyChallengeSteps->isEmpty()) {
            return response()->json(['message' => 'No daily challenge steps found'], Response::HTTP_NOT_FOUND);
        }

        return $dailyChallengeSteps;
    }

    /**
     * Create or update a daily challenge step.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int|null  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function createOrUpdate(Request $request, $id = null)
    {
        var_dump("je suis dans la");
        $request->validate([
            'stepCount' => 'required|integer',
            'day' => 'required|date',
            'challengeId' => 'required|exists:challenges,id',
        ]);

        if ($id) {
            // Update
            $dailyChallengeStep = DailyChallengeStep::find($id);
            if ($dailyChallengeStep) {
                $dailyChallengeStep->update($request->all());
                return response()->json($dailyChallengeStep, Response::HTTP_OK);
            } else {
                return response()->json(['message' => 'Daily challenge step not found'], Response::HTTP_NOT_FOUND);
            }
        } else {
            // Create
            $dailyChallengeStep = DailyChallengeStep::create($request->all());
            return response()->json($dailyChallengeStep, Response::HTTP_CREATED);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DailyChallengeStep  $dailyChallengeStep
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(DailyChallengeStep $dailyChallengeStep)
    {
        return response()->json($dailyChallengeStep, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DailyChallengeStep  $dailyChallengeStep
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, DailyChallengeStep $dailyChallengeStep)
    {
        $request->validate([
            'stepCount' => 'required|integer',
            'day' => 'required|date',
            'challengeId' => 'required|exists:challenges,id',
        ]);

        $dailyChallengeStep->update($request->all());

        return response()->json($dailyChallengeStep, Response::HTTP_OK);
    }

    /**
     * Delete a DailyChallengeStep.
     *
     * @param  DailyChallengeStep  $dailyChallengeStep
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(DailyChallengeStep $dailyChallengeStep)
    {
        $dailyChallengeStep->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
