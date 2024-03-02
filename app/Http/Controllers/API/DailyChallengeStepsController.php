<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DailyChallengeStep;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DailyChallengeStepsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return DailyChallengeStep::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'stepCount' => 'required|integer',
            'day' => 'required|date',
            'challengeId' => 'required|exists:challenges,id',
        ]);

        $dailyChallengeStep = DailyChallengeStep::create($request->all());

        return response()->json($dailyChallengeStep, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(DailyChallengeStep $dailyChallengeStep)
    {
        return response()->json($dailyChallengeStep, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
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
     * Remove the specified resource from storage.
     */
    public function destroy(DailyChallengeStep $dailyChallengeStep)
    {
        $dailyChallengeStep->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
