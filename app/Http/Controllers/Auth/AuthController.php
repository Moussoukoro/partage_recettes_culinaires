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
              'account_status' => 'active', // Add this line
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
    
        // Rechercher l'utilisateur par email
        $user = User::where('mail', $request->input('mail'))->first();
    
        // Vérifier si l'utilisateur existe et si le mot de passe est correct
        if ($user && Hash::check($request->input('password'), $user->password)) {
            // Vérifier le statut du compte
            if ($user->account_status !== 'active') {
                return back()->withErrors(['mail' => 'Votre compte est inactif. Veuillez contacter l\'administrateur.']);
            }
    
            // Connexion réussie
            Auth::login($user, $request->has('remember'));
            return redirect()->route('home');
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


    // Affiche le formulaire de modification du profil

public function editProfileForm() {
    $user = Auth::user();
    // Gardez la date au format Y-m-d pour l'input type="date"
    if ($user->dateNaiss) {
        $user->dateNaiss = \Carbon\Carbon::parse($user->dateNaiss)->format('Y-m-d');
    }
    return view('auth.edit-profile', ['user' => $user]);
}

// Mise à jour du profil
public function updateProfile(Request $request)
{
    // Validation des champs
    $request->validate([
        'nom' => 'required|string|max:255',
        'prenom' => 'required|string|max:255',
        'adresse' => 'required|string|max:255',
       'dateNaiss' => 'required|date_format:Y-m-d',
        'lieuNaiss' => 'required|string|max:255',
        'mail' => 'required|string|email|max:255|unique:users,mail,' . Auth::id(),
        'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'phone' => 'required|string|max:20',
        'nomUtilisateur' => 'required|string|max:255|unique:visiteurs,nomUtilisateur,' . Auth::user()->visiteur->id,
    ]);

    // Récupérer l'utilisateur connecté
    $user = Auth::user();

    // Gestion de la photo
    if ($request->hasFile('photo')) {
        // Supprimer l'ancienne photo si elle existe
        if ($user->photo) {
            \Storage::disk('public')->delete($user->photo);
        }
        // Sauvegarder la nouvelle photo
        $photoPath = $request->file('photo')->store('photos', 'public');
    }

    // Mise à jour des informations de l'utilisateur
    $user->update([
        'nom' => $request->nom,
        'prenom' => $request->prenom,
        'adresse' => $request->adresse,
        'dateNaiss' => $request->dateNaiss,
        'lieuNaiss' => $request->lieuNaiss,
        'mail' => $request->mail,
        'phone' => $request->phone,
        'photo' => $request->hasFile('photo') ? $photoPath : $user->photo,
    ]);

    // Mise à jour du nom d'utilisateur dans la table visiteur
    $user->visiteur->update([
        'nomUtilisateur' => $request->nomUtilisateur,
    ]);

    // Redirection avec message de succès
    return redirect()
        ->route('home')
        ->with('success', 'Profil mis à jour avec succès');
}

// Fonction pour modifier le mot de passe
public function updatePassword(Request $request)
{
    // Validation des champs
    $request->validate([
        'current_password' => 'required|string',
        'password' => 'required|string|min:4|confirmed',
    ]);

    // Vérifier si le mot de passe actuel est correct
    if (!Hash::check($request->current_password, Auth::user()->password)) {
        return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect']);
    }

    // Mise à jour du mot de passe
    Auth::user()->update([
        'password' => Hash::make($request->password)
    ]);

    return redirect()
        ->route('profile.edit')
        ->with('success', 'Mot de passe modifié avec succès');
}

public function toggleAccountStatus($userId)
{
    // Ensure only admin can access this method
    if (!Auth::user()->hasRole('admin')) {
        return redirect()->back()->with('error', 'Unauthorized access');
    }

    $user = User::findOrFail($userId);
    $newStatus = $user->account_status === 'active' ? 'inactive' : 'active';
    
    $user->update(['account_status' => $newStatus]);

    return redirect()->back()->with('success', 'Account status updated');
}




}

