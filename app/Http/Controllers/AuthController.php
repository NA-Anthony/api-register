<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Utilisateur;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum', ['only' => ['logout']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function register(Request $request)
    {
        // Validation des données
        $validated = $request->validate([
            'email' => 'required|email|unique:utilisateur,email',
            'mdp' => 'required|min:8|confirmed', // Assurez-vous d'ajouter 'confirmed' si vous utilisez des champs de confirmation
        ]);

        // Création de l'utilisateur
        $utilisateur = Utilisateur::create([
            'email' => $validated['email'],
            'mdp' => bcrypt($validated['mdp']), // Assurez-vous de hacher le mot de passe
        ]);

        // Retourner la réponse
        return response()->json([
            'message' => 'Utilisateur créé avec succès!',
            'utilisateur' => $utilisateur
        ], 201);
    }


    public function login(Request $request)
    {
        return (new Utilisateur)->authenticate($request);
    }

    public function verifyPin(Request $request)
    {
        return (new Utilisateur)->verifyPin($request);
    }

    // Déconnexion
    public function logout(Request $request)
    {
        Auth::logout();

        return response()->json(['message' => 'Déconnexion réussie']);
    }
}
