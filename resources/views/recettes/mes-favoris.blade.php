@extends('layouts.entete')

@section('content')
<section class="favorites_section layout_padding">
    <div class="container">
        <div class="heading_container heading_center">
            <h2>Mes Recettes Favorites</h2>
        </div>

        <div class="row">
            @forelse($recettesFavorites as $recette)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        @if($recette->image)
                            <img src="{{ asset('storage/' . $recette->image) }}" 
                                 class="card-img-top" 
                                 alt="{{ $recette->titre }}"
                                 style="height: 200px; object-fit: cover;">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $recette->titre }}</h5>
                            <p class="card-text">{{ Str::limit($recette->description, 100) }}</p>
                            
                            <div class="recipe-info mb-3">
                                <small class="text-muted">
                                    <i class="fas fa-clock"></i> {{ $recette->tempsPreparation }} min
                                </small>
                                <small class="text-muted ms-2">
                                    <i class="fas fa-user"></i> {{ $recette->visiteur->user->prenom }}
                                </small>
                            </div>

                            <div class="recipe-categories mb-3">
                                @foreach($recette->categories as $categorie)
                                    <span class="badge bg-secondary">{{ $categorie->nom }}</span>
                                @endforeach
                            </div>
                        </div>
                        
                        <div class="card-footer bg-transparent">
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('recettes.show', $recette) }}" 
                                   class="btn btn-primary w-auto px-9">
                                    Voir la recette
                                </a>
                                <button class="btn btn-sm btn-outline-danger favori-btn"
                                        data-recette-id="{{ $recette->id }}"
                                        onclick="toggleFavori({{ $recette->id }})">
                                    <i class="fas fa-heart"></i> Retirer des favoris
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p>Vous n'avez pas encore de recettes favorites.</p>
                    <a href="{{ route('recettes.index') }}" class="btn btn-primary mt-3">
                        Découvrir des recettes
                    </a>
                </div>
            @endforelse
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $recettesFavorites->links() }}
        </div>
    </div>
</section>

@push('scripts')
<script>
function toggleFavori(recetteId) {
    fetch(`/recettes/${recetteId}/favori`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({})
    })
    .then(response => response.json())
    .then(data => {
        if (!data.favorited) {
            // Retirer la carte de la vue
            const card = document.querySelector(`[data-recette-id="${recetteId}"]`).closest('.col-md-4');
            card.remove();
            
            // Si plus de favoris, afficher le message
            if (document.querySelectorAll('.card').length === 0) {
                location.reload();
            }
        }
    })
    .catch(error => console.error('Erreur:', error));
}
</script>
@endpush
@endsection