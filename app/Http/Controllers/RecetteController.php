<?php

namespace App\Http\Controllers;

use App\Models\Recette;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RecetteController extends Controller
{
    /**
     * Afficher la liste de toutes les recettes
     */
    public function index()
    {
        $recettes = Recette::with('visiteur')->latest()->paginate(12);
        return view('recettes.index', compact('recettes'));
    }

    /**
     * Afficher mes recettes
     */
    public function mesRecettes()
    {
        $recettes = Auth::user()->recettes()->latest()->paginate(12);
        return view('recettes.mes-recettes', compact('recettes'));
    }

    /**
     * Afficher le formulaire de création
     */
    public function create()
    {
        return view('recettes.create');
    }

    /**
     * Enregistrer une nouvelle recette
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|max:255',
            'description' => 'nullable',
            'categories' => 'required|array', // Assurez-vous qu'un tableau de catégories est envoyé
            'categories.*' => 'exists:categories,id', // Vérifiez que chaque catégorie existe
            'ingredient' => 'required',
            'instruction' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video' => 'nullable|url',
            'tempsPreparation' => 'required|integer|min:1',
        ]);

        // Gérer l'upload de l'image
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('recettes', 'public');
            $validated['image'] = $imagePath;
        }

    // Récupérer l'ID du visiteur associé à l'utilisateur connecté
    $visiteur_id = Auth::user()->visiteur->id;
        // Ajouter les champs automatiques
        $validated['visiteur_id'] =$visiteur_id;
        $validated['dateCreation'] = now();
        $validated['heureCreation'] = now()->format('H:i:s');

       
            // Créer la recette
            $recette = Recette::create($validated);
         // Synchroniser les catégories avec la table pivot
         $recette->categories()->sync($request->categories);

        return redirect()->route('mes-recettes')
            ->with('success', 'Votre recette a été ajoutée avec succès!');
    }

    /**
     * Afficher une recette spécifique
     */
    public function show(Recette $recette)
    {

        return view('recettes.show', compact('recette'));
 
    }

    /**
     * Afficher le formulaire de modification
     */
    public function edit(Recette $recette)
    {
        // Vérifier que l'utilisateur est bien le propriétaire de la recette
        if ($recette->visiteur_id !== Auth::id()) {
            return redirect()->route('recettes.index')
                ->with('error', 'Vous n\'êtes pas autorisé à modifier cette recette.');
        }

        return view('recettes.edit', compact('recette'));
    }

    /**
     * Mettre à jour une recette
     */
    public function update(Request $request, Recette $recette)
    {
        // Vérifier que l'utilisateur est bien le propriétaire de la recette
        if ($recette->visiteur_id !== Auth::id()) {
            return redirect()->route('recettes.index')
                ->with('error', 'Vous n\'êtes pas autorisé à modifier cette recette.');
        }

        $validated = $request->validate([
            'titre' => 'required|max:255',
            'description' => 'nullable',
            'ingredient' => 'required',
            'instruction' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video' => 'nullable|url',
            'tempsPreparation' => 'required|integer|min:1',
        ]);

        // Gérer l'upload de la nouvelle image
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image si elle existe
            if ($recette->image) {
                Storage::disk('public')->delete($recette->image);
            }
            $imagePath = $request->file('image')->store('recettes', 'public');
            $validated['image'] = $imagePath;
        }

        $recette->update($validated);

        return redirect()->route('mes-recettes')
            ->with('success', 'Votre recette a été mise à jour avec succès!');
    }

    /**
     * Supprimer une recette
     */
    public function destroy(Recette $recette)
    {
        // Vérifier que l'utilisateur est bien le propriétaire de la recette
        if ($recette->visiteur_id !== Auth::id()) {
            return redirect()->route('recettes.index')
                ->with('error', 'Vous n\'êtes pas autorisé à supprimer cette recette.');
        }

        // Supprimer l'image associée si elle existe
        if ($recette->image) {
            Storage::disk('public')->delete($recette->image);
        }

        $recette->delete();

        return redirect()->route('mes-recettes')
            ->with('success', 'Votre recette a été supprimée avec succès!');
    }
}