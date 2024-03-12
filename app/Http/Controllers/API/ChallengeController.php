<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Challenge;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ChallengeController extends Controller
{
    /**
     * Retrieve all challenges.
     *
     * @return \Illuminate\Database\Eloquent\Collection|Challenge[]
     */
    public function index()
    {
        return Challenge::orderBy('endAt', 'desc')->get();
    }

    /**
     * Create or update a challenge.
     *
     * @param \Illuminate\Http\Request $request The HTTP request object.
     * @param int|null $challengeId The ID of the challenge to update (optional).
     * @return \Illuminate\Http\JsonResponse The JSON response containing the result of the operation.
     */
    public function createOrUpdate(Request $request, $challengeId = null)
    {
        $request->validate([
            'startAt' => 'required|date',
            'endAt' => 'required|date',
            'name' => 'required',
            'password' => 'required',
            'description' => 'required',
        ]);

        $challenge = $challengeId ? Challenge::find($challengeId) : new Challenge;

        if (!$challenge && $challengeId) {
            return response()->json(['error' => 'Challenge not found'], Response::HTTP_NOT_FOUND);
        }

        $challenge->startAt = $request->input('startAt');
        $challenge->endAt = $request->input('endAt');
        $challenge->password = $request->input('password');
        $challenge->name = $request->input('name');
        $challenge->description = $request->input('description');

        $challenge->save();

        return response()->json(['message' => 'Challenge saved successfully', 'challenge' => $challenge], Response::HTTP_OK);
    }


    /**
     * Display the specified challenge.
     *
     * @param  int  $challengeId
     * @return \Illuminate\Http\Response
     */
    public function show($challengeId)
    {
        $challenge = Challenge::find($challengeId);
        if (!$challenge) {
            return response()->json(['error' => 'Challenge not found'], Response::HTTP_NOT_FOUND);
        }
        return response()->json($challenge, Response::HTTP_OK);
    }

    /**
     * Destroy a challenge.
     *
     * @param int $challengeId The ID of the challenge to be destroyed.
     * @return \Illuminate\Http\Response
     */
    public function destroy($challengeId)
    {
        $challenge = Challenge::find($challengeId);
        if (!$challenge) {
            return response()->json(['error' => 'Challenge not found'], Response::HTTP_NOT_FOUND);
        }
        $challenge->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
