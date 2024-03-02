<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            // Spécifiez les règles de validation pour les champs à ajouter ici
        ]);

        // Créez un nouvel utilisateur avec les données de la requête
        $user = User::create($request->all());

        // Retournez la réponse avec le statut HTTP 201 (Created) et les données de l'utilisateur créé
        return response()->json($user, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return response()->json($user, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            // Spécifiez les règles de validation pour les champs à mettre à jour ici
        ]);

        // Mettez à jour les informations de l'utilisateur avec les données de la requête
        $user->update($request->all());

        // Retournez la réponse avec le statut HTTP 200 (OK) et les données de l'utilisateur mis à jour
        return response()->json($user, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Supprimez l'utilisateur de la base de données
        $user->delete();

        // Retournez une réponse vide avec le statut HTTP 204 (No Content) pour indiquer que l'utilisateur a été supprimé
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
