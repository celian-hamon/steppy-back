<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Challenge;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ChallengeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Challenge::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'startAt' => 'required|date',
            'endAt' => 'required|date',
            'allSteps' => 'required|integer',
            'password' => 'required|string',
            'name' => 'required|string',
            'description' => 'required|string',
        ]);

        $challenge = Challenge::create($request->all());

        return response()->json($challenge, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Challenge $challenge)
    {
        return response()->json($challenge, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Challenge $challenge)
    {
        $request->validate([
            'startAt' => 'required|date',
            'endAt' => 'required|date',
            'allSteps' => 'required|integer',
            'password' => 'required|string',
            'name' => 'required|string',
            'description' => 'required|string',
        ]);

        $challenge->update($request->all());

        return response()->json($challenge, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Challenge $challenge)
    {
        $challenge->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
