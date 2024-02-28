<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Badge;
use Illuminate\Http\Request;

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

        return Badge::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Badge $badge)
    {
        return $badge;
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

        return $badge;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Badge $badge)
    {
        $badge->delete();

        return response()->json(null, 204);
    }
}
