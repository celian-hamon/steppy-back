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
     * Store or update a badge.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int|null  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeOrUpdate(Request $request, $id = null)
    {
        $request->validate([
            'image' => 'required|string',
            'name' => 'required|string',
            'description' => 'required|string',
            'isStreak' => 'required|boolean',
            'quantity' => 'required|integer',
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
