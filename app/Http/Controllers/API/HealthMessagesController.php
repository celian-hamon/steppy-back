<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\HealthMessage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class HealthMessagesController extends Controller
{
    /**
     * Retrieve all health messages.
     *
     * @return \Illuminate\Database\Eloquent\Collection|HealthMessage[]
     */
    public function index()
    {
        return HealthMessage::all();
    }

    /**
     * Display a random health message.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function showRandom()
    {
        $healthMessage = HealthMessage::inRandomOrder()->first();

        if ($healthMessage) {
            return response()->json($healthMessage, Response::HTTP_OK);
        } else {
            return response()->json(['error' => 'No health messages found'], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Display the specified health message.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $healthMessage = HealthMessage::find($id);

        if ($healthMessage) {
            return response()->json($healthMessage, Response::HTTP_OK);
        } else {
            return response()->json(['error' => 'HealthMessage not found'], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Create or update a health message.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int|null  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function createOrUpdate(Request $request, $id = null)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        if ($id) {
            // Update
            $healthMessage = HealthMessage::find($id);
            if ($healthMessage) {
                $healthMessage->update($request->all());
                return response()->json($healthMessage, Response::HTTP_OK);
            } else {
                return response()->json(['error' => 'HealthMessage not found'], Response::HTTP_NOT_FOUND);
            }
        } else {
            // Create
            $healthMessage = HealthMessage::create($request->all());
            return response()->json($healthMessage, Response::HTTP_CREATED);
        }
    }

    /**
     * Delete a health message.
     *
     * @param  int  $id  The ID of the health message to delete.
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $healthMessage = HealthMessage::find($id);

        if ($healthMessage) {
            $healthMessage->delete();
            return response()->json(null, Response::HTTP_NO_CONTENT);
        } else {
            return response()->json(['error' => 'HealthMessage not found'], Response::HTTP_NOT_FOUND);
        }
    }
}
