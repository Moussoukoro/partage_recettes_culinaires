@extends('layouts.entete')

@section('content')
<div class="container py-5">
    <h1 class="text-center mb-4">Toutes les Recettes</h1>

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
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">Par {{ $recette->user->prenom }} {{ $recette->visiteur->user->nom }}</small>
                            <small class="text-muted">{{ $recette->tempsPreparation }} min</small>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent">
                        <a href="{{ route('recettes.show', $recette) }}" class="btn btn-primary w-100">Voir la recette</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <p class="text-center">Aucune recette n'a été publiée pour le moment.</p>
            </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $recettes->links() }}
    </div>
</div>
@endsection