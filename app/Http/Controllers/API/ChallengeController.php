<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Challenge;
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
     * @param Request $request
     * @param int|null $challengeId
     * @return JsonResponse
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
     * @param int $challengeId
     * @return JsonResponse
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
     * @param int $challengeId
     * @return JsonResponse
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
