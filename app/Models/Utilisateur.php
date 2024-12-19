<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class Utilisateur extends Authenticatable
{
    use Notifiable;  // Permet l'envoi de notifications, si nécessaire

    protected $table = 'utilisateur';
    protected $fillable = ['email', 'mdp', 'nom', 'isverified', 'tentative', 'code_pin', 'bloque'];

    protected $casts = [
        'isverified' => 'boolean',
        'tentative' => 'integer'
    ];

    // Si vous avez besoin de configurer le mot de passe (en hachage)
    protected $hidden = [
        'mdp',
    ];

    // La méthode que Laravel utilise pour vérifier le mot de passe
    public function getAuthPassword()
    {
        return $this->mdp;  // Retourne le mot de passe haché
    }

    public function authenticate(\Illuminate\Http\Request $request)
    {
        \Log::info('authenticate method called', ['data' => $request->all()]);
        // Valider les entrées
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Chercher l'utilisateur par email
        $user = Utilisateur::where('email', $request->email)->first();

        if (!$user) {
            \Log::error('Email not found', ['email' => $request->email]);
            return response()->json(['message' => 'Email non trouvé'], 404);
        }

        // Vérifier le mot de passe
        if (!Hash::check($request->password, $user->mdp)) {
            $user->increment('tentative'); // Augmenter le compteur des tentatives
            $user->save();

            if ($user->tentative >= 3) { // Remplacer "3" par votre valeur maximale de tentatives
                $user->update(['bloque' => true]); // Bloquer le compte
                return response()->json(['message' => 'Compte bloqué en raison de tentatives échouées'], 403);
            }
            \Log::warning('Incorrect password', ['email' => $request->email]);

            return response()->json(['message' => 'Mot de passe incorrect. Tentative : ' . $user->tentative], 401);
        }

        // Générer un code PIN
        $pin = Str::random(6); // Code PIN aléatoire
        $user->update([
            'code_pin' => $pin,
            'tentative' => 0, // Réinitialiser les tentatives
        ]);

        // Envoyer un email avec le code PIN
        Mail::to($user->email)->send(new \App\Mail\PinCodeMail($pin));

        return response()->json(['message' => 'Code PIN envoyé à votre email. Veuillez confirmer le compte.']);
    }

    public function verifyPin(Request $request)
    {
        // Valider les entrées
        $request->validate([
            'email' => 'required|email',
            'pin' => 'required',
        ]);

        // Chercher l'utilisateur par email
        $user = Utilisateur::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'Email non trouvé'], 404);
        }

        // Vérifier si le compte est bloqué
        if ($user->bloque) {
            return response()->json(['message' => 'Compte bloqué.'], 403);
        }

        // Vérifier le code PIN
        if ($user->code_pin !== $request->pin) {
            $user->increment('tentative'); // Augmenter le compteur des tentatives
            $user->save();

            if ($user->tentative >= 3) { // Remplacer "3" par votre valeur maximale de tentatives
                $user->update(['bloque' => true]); // Bloquer le compte
                return response()->json(['message' => 'Compte bloqué en raison de tentatives échouées'], 403);
            }

            return response()->json(['message' => 'Code PIN incorrect. Tentative : ' . $user->tentative], 401);
        }

        // Si le code PIN est correct
        $user->update([
            'code_pin' => null, // Réinitialiser le code PIN
            'tentative' => 0,   // Réinitialiser les tentatives
        ]);

        return response()->json(['message' => 'Compte confirmé avec succès!']);
    }
}

