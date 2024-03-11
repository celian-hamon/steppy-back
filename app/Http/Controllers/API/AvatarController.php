<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Avatar;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AvatarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Avatar::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        var_dump("JE PASSE");
        $request->validate([
            'image' => 'required|string',
            'name' => 'required|string',
            'badgeId' => 'required|integer|exists:badges,id'
        ]);

        $avatar = Avatar::create($request->all());

        return response()->json($avatar, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $avatar = Avatar::find($id);
        if (!$avatar) {
            return response()->json(['message' => 'Avatar not found'], Response::HTTP_NOT_FOUND);
        }
        return response()->json($avatar, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $avatar = Avatar::find($id);
        if (!$avatar) {
            return response()->json(['message' => 'Avatar not found'], Response::HTTP_NOT_FOUND);
        }

        $request->validate([
            'image' => 'string',
            'name' => 'string',
            'badgeId' => 'integer|exists:badges,id'
        ]);

        $avatar->update($request->all());

        return response()->json($avatar, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $avatar = Avatar::find($id);
        if (!$avatar) {
            return response()->json(['message' => 'Avatar not found'], Response::HTTP_NOT_FOUND);
        }

        $avatar->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
