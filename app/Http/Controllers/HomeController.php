<?php

namespace App\Http\Controllers;
use App\Models\Categorie;

use Illuminate\Http\Request;


class HomeController extends Controller
{
    public function index()
    {
        // // Récupérer les recettes de l'utilisateur connecté
        // $userRecipes = Recipe::where('auteur', Auth::id())->get();

    // Récupérer toutes les catégories
     $categories = Categorie::all();

         return view('home',compact('categories'));
    }
}
