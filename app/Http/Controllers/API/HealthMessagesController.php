<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\HealthMessage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class HealthMessagesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return HealthMessage::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $healthMessage = HealthMessage::create($request->all());

        return response()->json($healthMessage, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(HealthMessage $healthMessage)
    {
        return response()->json($healthMessage, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HealthMessage $healthMessage)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $healthMessage->update($request->all());

        return response()->json($healthMessage, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HealthMessage $healthMessage)
    {
        $healthMessage->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
