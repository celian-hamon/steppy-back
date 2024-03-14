<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Badge;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BadgeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Badge::all();
    }
    
    /**
     * Display the specified badge.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $badge = Badge::find($id);
        if (!$badge) {
            return response()->json(['message' => 'Badge not found'], Response::HTTP_NOT_FOUND);
        }
        return response()->json($badge, Response::HTTP_OK);
    }

    public function showAllBadgesWithAvatar()
    {
        $badges = Badge::with('avatars')->get();
        return response()->json($badges, Response::HTTP_OK);
    }
    
    /**
     * Display the badge with its associated avatars.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function showBadgeWithAvatar($id)
    {
        $badge = Badge::with('avatars')->find($id);
    
        if (!$badge) {
            return response()->json(['message' => 'Badge not found'], Response::HTTP_NOT_FOUND);
        }
    
        return response()->json($badge, Response::HTTP_OK);
    }

    /**
     * Create or update a badge.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int|null  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function createOrUpdate(Request $request, $id = null)
    {
        $request->validate([
            'image' => 'required|string',
            'name' => 'required|string',
            'description' => 'required|string',
            'isGlobal' => 'required|boolean',
            'isStreak' => 'required|boolean',
            'quantity' => 'required|integer',
            'avatarId' => 'required|integer'
        ]);

        if ($id) {
            // Update
            $badge = Badge::find($id);
            if ($badge) {
                $badge->update($request->all());
                return response()->json($badge, Response::HTTP_OK);
            } else {
                return response()->json(['error' => 'Badge not found'], Response::HTTP_NOT_FOUND);
            }
        } else {
            // Create
            $badge = Badge::create($request->all());
            return response()->json($badge, Response::HTTP_CREATED);
        }
    }

    /**
     * Retrieve all individual success badges.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function showAllIndividualBadges()
    {
        $badges = Badge::where('isGlobal', false)->orderBy('id', 'asc')->get();
        if ($badges->isEmpty()) {
            return response()->json(['message' => 'No individual success found'], Response::HTTP_NOT_FOUND);
        }
        return response()->json($badges, Response::HTTP_OK);
    }

    /**
     * Retrieve all global success badges.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function showAllGlobalBadges()
    {
        $badges = Badge::where('isGlobal', true)->get();
        if ($badges->isEmpty()) {
            return response()->json(['message' => 'No global success found'], Response::HTTP_NOT_FOUND);
        }
        return response()->json($badges, Response::HTTP_OK);
    }

    /**
     * Delete a badge.
     *
     * @param  int  $id  The ID of the badge to delete.
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $badge = Badge::find($id);
        if (!$badge) {
            return response()->json(['message' => 'Badge not found'], Response::HTTP_NOT_FOUND);
        }

        $badge->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
