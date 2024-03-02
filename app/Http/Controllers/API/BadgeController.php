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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|string',
            'name' => 'required|string',
            'description' => 'required|string',
        ]);

        $badge = Badge::create($request->all());

        return response()->json($badge, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Badge $badge)
    {
        return response()->json($badge, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Badge $badge)
    {
        $request->validate([
            'image' => 'required|string',
            'name' => 'required|string',
            'description' => 'required|string',
        ]);

        $badge->update($request->all());

        return response()->json($badge, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Badge $badge)
    {
        $badge->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
