@extends('layouts.entete')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                @if($recette->image)
                    <img src="{{ asset('storage/' . $recette->image) }}" class="card-img-top" alt="{{ $recette->titre }}">
                @endif
                
                <div class="card-body">
                    <h1 class="card-title mb-4">{{ $recette->titre }}</h1>
                    
                    <div class="mb-4">
                        <p class="text-muted">
                            <i class="fas fa-user"></i> Par {{ $recette->visiteur->user->prenom }} {{ $recette->visiteur->user->nom }} <br>
                            <i class="fas fa-clock"></i> Temps de préparation: {{ $recette->tempsPreparation }} minutes <br>
                            <i class="fas fa-calendar"></i> Publié le {{ \Carbon\Carbon::parse($recette->dateCreation)->format('d/m/Y') }}
                        </p>
                    </div>

                    @if($recette->categories->count() > 0)
                        <div class="mb-4">
                            <h4>Catégories</h4>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($recette->categories as $categorie)
                                    <span class="badge bg-primary">{{ $categorie->nom }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if($recette->description)
                        <div class="mb-4">
                            <h4>Description</h4>
                            <p>{{ $recette->description }}</p>
                        </div>
                    @endif

                    @if($recette->video)
                        <div class="mb-4">
                            <h4>Vidéo de la recette</h4>
                            <div class="ratio ratio-16x9">
                                <iframe src="{{ str_replace('watch?v=', 'embed/', $recette->video) }}" 
                                        allowfullscreen></iframe>
                            </div>
                        </div>
                    @endif

                    <div class="mb-4">
                        <h4>Ingrédients</h4>
                        {!! nl2br(e($recette->ingredient)) !!}
                    </div>

                    <div class="mb-4">
                        <h4>Instructions</h4>
                        {!! nl2br(e($recette->instruction)) !!}
                    </div>

                    @if(Auth::id() === $recette->visiteur_id)
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('recettes.edit', $recette) }}" class="btn btn-warning">Modifier</a>
                            <form action="{{ route('recettes.destroy', $recette) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" 
                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette recette ?')">
                                    Supprimer
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('recettes.index') }}" class="btn btn-secondary">Retour aux recettes</a>
            </div>
        </div>
    </div>
</div>
@endsection