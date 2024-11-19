<?php

namespace App\Http\Controllers;

use App\Models\Recette;
use App\Models\Categorie;
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
        $recettes = Recette::withCount(['aimes', 'favories', 'commentaires'])
            ->with(['visiteur', 'categories', 'commentaires.visiteur'])
            ->latest()
            ->paginate(12);
        return view('recettes.index', compact('recettes'));
    }

    /**
     * Afficher mes recettes
     */
    public function mesRecettes()
    {
        $recettes = Auth::user()->recettes()->with('categories')->latest()->paginate(12);
        $categories = Categorie::all(); // Ajout pour le formulaire de création
        return view('recettes.mes-recettes', compact('recettes', 'categories'));
    }

    /**
     * Afficher le formulaire de création
     */
    public function create()
    {
        $categories = Categorie::all();
        return view('recettes.create', compact('categories'));
    }

    /**
     * Enregistrer une nouvelle recette
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|max:255',
            'description' => 'nullable',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
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
        
        // Créer la recette
        $recette = Recette::create([
            'titre' => $validated['titre'],
            'description' => $validated['description'],
            'ingredient' => $validated['ingredient'],
            'instruction' => $validated['instruction'],
            'image' => $validated['image'] ?? null,
            'video' => $validated['video'] ?? null,
            'tempsPreparation' => $validated['tempsPreparation'],
            'visiteur_id' => $visiteur_id,
            'dateCreation' => now(),
            'heureCreation' => now()->format('H:i:s')
        ]);

        // Attacher les catégories
        $recette->categories()->attach($request->categories);

        return redirect()->route('mes-recettes')
            ->with('success', 'Votre recette a été ajoutée avec succès!');
    }

    /**
     * Afficher une recette spécifique
     */
    public function show(Recette $recette)
    {
        $recette->load('categories'); // Charger les catégories
        return view('recettes.show', compact('recette'));
    }

    /**
     * Afficher le formulaire de modification
     */
    public function edit(Recette $recette)
    {
        if ($recette->visiteur->user_id !== Auth::id()) {
            return redirect()->route('recettes.index')
                ->with('error', 'Vous n\'êtes pas autorisé à modifier cette recette.');
        }

        $categories = Categorie::all();
        return view('recettes.edit', compact('recette', 'categories'));
    }

    /**
     * Mettre à jour une recette
     */
    public function update(Request $request, Recette $recette)
    {
        // Attention : la condition était inversée !
        if ($recette->visiteur->user_id !== Auth::id()) {
            return redirect()->route('recettes.index')
                ->with('error', 'Vous n\'êtes pas autorisé à modifier cette recette.');
        }

        $validated = $request->validate([
            'titre' => 'required|max:255',
            'description' => 'nullable',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
            'ingredient' => 'required',
            'instruction' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video' => 'nullable|url',
            'tempsPreparation' => 'required|integer|min:1',
        ]);

        // Gérer l'upload de la nouvelle image
        if ($request->hasFile('image')) {
            if ($recette->image) {
                Storage::disk('public')->delete($recette->image);
            }
            $imagePath = $request->file('image')->store('recettes', 'public');
            $validated['image'] = $imagePath;
        }

        $recette->update($validated);
        
        // Synchroniser les catégories
        $recette->categories()->sync($request->categories);

        return redirect()->route('mes-recettes')
            ->with('success', 'Votre recette a été mise à jour avec succès!');
    }

    /**
     * Supprimer une recette
     */
    public function destroy(Recette $recette)
    {
        if ($recette->visiteur->user_id !== Auth::id()) {
            return redirect()->route('recettes.index')
                ->with('error', 'Vous n\'êtes pas autorisé à supprimer cette recette.');
        }

        // Supprimer l'image associée
        if ($recette->image) {
            Storage::disk('public')->delete($recette->image);
        }

        // Détacher toutes les catégories avant de supprimer
        $recette->categories()->detach();
        $recette->delete();

        return redirect()->route('mes-recettes')
            ->with('success', 'Votre recette a été supprimée avec succès!');
    }

   public function aimer(Request $request, Recette $recette)
{
    \Log::info('Aimer action called', ['recette_id' => $recette->id]);
    
    if (!Auth::check()) {
        \Log::warning('Unauthorized like attempt');
        return response()->json(['error' => 'Non autorisé'], 401);
    }

    $visiteur = Auth::user()->visiteur;
    \Log::info('User info', ['visiteur_id' => $visiteur->id]);
    
    try {
        if ($recette->aimes->contains($visiteur->id)) {
            $recette->aimes()->detach($visiteur->id);
            $liked = false;
        } else {
            $recette->aimes()->attach($visiteur->id);
            $liked = true;
        }

        $count = $recette->aimes()->count();
        \Log::info('Like operation successful', ['liked' => $liked, 'count' => $count]);

        return response()->json([
            'liked' => $liked,
            'count' => $count
        ]);
    } catch (\Exception $e) {
        \Log::error('Error in aimer function', ['error' => $e->getMessage()]);
        return response()->json(['error' => 'Une erreur est survenue'], 500);
    }
}
    public function favori(Request $request, Recette $recette)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Non autorisé'], 401);
        }

        $visiteur = Auth::user()->visiteur;
        
        if ($recette->favories->contains($visiteur->id)) {
            $recette->favories()->detach($visiteur->id);
            $favorited = false;
        } else {
            $recette->favories()->attach($visiteur->id);
            $favorited = true;
        }

        return response()->json([
            'favorited' => $favorited,
            'count' => $recette->favories()->count()
        ]);
    }

 

}