<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AuthController extends Controller
{

      // Affiche le formulaire d'inscription
      public function RegisterForm()
      {
          return view('auth.register');
      }


      public function register(Request $request)
      {
          // Validation des champs d'inscription
          $request->validate([
              'nom' => 'required|string|max:255',
              'prenom' => 'required|string|max:255',
              'adresse' => 'required|string|max:255',
              'dateNaiss' => 'required|date',
              'lieuNaiss' => 'required|string|max:255',
              'mail' => 'required|string|email|max:255|unique:users',
              'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Photo optionnelle
              'phone' => 'required|string|max:20',
              'password' => 'required|string|min:4|confirmed',  // Validation du mot de passe
              'nomUtilisateur' => 'required|string|max:255|unique:visiteurs', // Validation du nom d'utilisateur
          ]);
      
          // Gestion du téléchargement de la photo (si elle est fournie)
          $photoPath = null;
          if ($request->hasFile('photo')) {
              $photoPath = $request->file('photo')->store('photos', 'public');
          }
      
          // Création de l'utilisateur avec les données valides
          $user = User::create([
              'nom' => $request->nom,
              'prenom' => $request->prenom,
              'adresse' => $request->adresse,
              'role' => 'visiteur',  // Définir le rôle par défaut sur 'visiteur'
              'dateNaiss' => $request->dateNaiss,
              'lieuNaiss' => $request->lieuNaiss,
              'mail' => $request->mail,
              'photo' => $photoPath,
              'phone' => $request->phone,
              'password' => Hash::make($request->password),  // Hash du mot de passe
          ]);
      
          // Ajouter le nom d'utilisateur dans la table 'visiteur'
          \App\Models\Visiteur::create([
              'nomUtilisateur' => $request->nomUtilisateur,  // Le nom d'utilisateur
              'user_id' => $user->id,  // Lier l'utilisateur à la table 'visiteur'
          ]);
      
          // Connexion automatique de l'utilisateur après l'enregistrement
          Auth::login($user);
      
          // Rediriger vers la page d'accueil ou autre page
          return redirect()->route('home');
      }
      
   // Affiche le formulaire de connexion
   public function LoginForm()
   {
       return view('auth.login');
   }


    // Fonction de connexion
    public function login(Request $request)
    {
        
     
        // Validation des informations de connexion
        $request->validate([
            'mail' => 'required|string|email|max:255',
            'password' => 'required|string|min:4',
        ]);
        // Affiche les données envoyées à Auth::attempt()


         
      // Tentative de connexion avec les bons champs
      if (Auth::attempt([
        'mail' => $request->input('mail'),
        'password' => $request->input('password'),
    ], $request->has('remember'))) {
        return redirect()->route('home');  // Redirection après connexion réussie
    }
        // Retourner une erreur si la connexion échoue
        return back()->withErrors(['mail' => 'Les informations d\'identification sont incorrectes.']);
    }

    // Fonction de déconnexion
    public function logout()
    {
        Auth::logout();
        return redirect()->route('home');
    }
}

