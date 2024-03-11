<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DailyStep;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DailyStepsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return DailyStep::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'stepCount' => 'required|integer',
            'day' => 'required|date',
            'userId' => 'required|exists:users,id',
        ]);

        $dailyStep = DailyStep::create($request->all());

        return response()->json($dailyStep, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(DailyStep $dailyStep)
    {
        return response()->json($dailyStep, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DailyStep $dailyStep)
    {
        $request->validate([
            'stepCount' => 'required|integer',
            'day' => 'required|date',
            'userId' => 'required|exists:users,id',
        ]);

        $dailyStep->update($request->all());

        return response()->json($dailyStep, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DailyStep $dailyStep)
    {
        $dailyStep->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
