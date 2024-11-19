<?php

namespace App\Http\Controllers;

use App\Models\Commentaire;
use App\Models\Recette;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentaireController extends Controller
{
    /**
     * Store a newly created comment in storage.
     */
    public function store(Request $request)
    {
        // Validation des données
        $validatedData = $request->validate([
            'recette_id' => 'required|exists:recettes,id',
            'contenu' => 'required|string|min:2',
        ]);

        // Vérifier si l'utilisateur est connecté et a un visiteur associé
        if (!Auth::check() || !Auth::user()->visiteur) {
            return back()->with('error', 'Vous devez être connecté pour commenter.');
        }

        try {
            // Création du commentaire
            $commentaire = Commentaire::create([
                'contenu' => $validatedData['contenu'],
                'recette_id' => $validatedData['recette_id'],
                'visiteur_id' => Auth::user()->visiteur->id,
            ]);

            return back()->with('success', 'Votre commentaire a été ajouté avec succès !');

        } catch (\Exception $e) {
            return back()->with('error', 'Une erreur est survenue lors de l\'ajout du commentaire.');
        }
    }

    /**
     * Remove the specified comment from storage.
     */
    public function destroy(Commentaire $commentaire)
    {
        // Vérifier si l'utilisateur est autorisé à supprimer le commentaire
        if (!Auth::check() || 
            (Auth::user()->visiteur->id !== $commentaire->visiteur_id && 
             !Auth::user()->isAdmin())) {
            return response()->json([
                'success' => false,
                'message' => 'Vous n\'êtes pas autorisé à supprimer ce commentaire.'
            ], 403);
        }

        try {
            $recetteId = $commentaire->recette_id;
            $commentaire->delete();

            return response()->json([
                'success' => true,
                'message' => 'Commentaire supprimé avec succès',
                'count' => Recette::find($recetteId)->commentaires()->count()
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la suppression du commentaire.'
            ], 500);
        }
    }
}