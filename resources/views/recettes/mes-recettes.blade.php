@extends('layouts.entete')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Mes Recettes</h1>
        <a href="{{ route('recettes.create') }}"  class="btn btn-primary w-auto px-5">Ajouter une recette</a>
    </div>

    <div class="row">
        @forelse ($recettes as $recette)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    @if($recette->image)
                        <img src="{{ asset('storage/' . $recette->image) }}" class="card-img-top" alt="{{ $recette->titre }}" style="height: 200px; object-fit: cover;">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $recette->titre }}</h5>
                        <p class="card-text">{{ Str::limit($recette->description, 100) }}</p>
                        @if($recette->video)
                            <div class="video-badge mb-2">
                                <i class="fas fa-video"></i> Vidéo disponible
                            </div>
                        @endif
                        <p class="card-text"><small class="text-muted">Temps de préparation: {{ $recette->tempsPreparation }} min</small></p>
                    </div>
                    <div class="card-footer bg-transparent">
                        <div class="btn-group w-100">
                            <a href="{{ route('recettes.show', $recette) }}" class="btn btn-info">Voir</a>
                            <a href="{{ route('recettes.edit', $recette) }}" class="btn btn-warning">Modifier</a>
                            <form action="{{ route('recettes.destroy', $recette) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette recette ?')">Supprimer</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">
                    Vous n'avez pas encore créé de recettes. 
                    <a href="{{ route('recettes.create') }}" class="alert-link">Créez votre première recette</a>
                </div>
            </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $recettes->links() }}
    </div>
</div>
@endsection