@extends('layouts.entete')

@section('content')
<section class="home_section layout_padding">
  <div class="container">
    <div class="col-md-8 mx-auto">
      <div class="heading_container heading_center">
        <h2>Bienvenue {{ Auth::user()->prenom }} {{ Auth::user()->nom }}</h2>
      </div>

      <div class="user_info_box">
        <div class="row">
          <div class="col-md-4">
            <div class="user_avatar">
              <img src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : asset('images/default-avatar.png') }}" alt="Votre Photo" class="img-fluid rounded-circle">
            </div>
          </div>
          <div class="col-md-8">
            <div class="user_details">
              <p><strong>Email :</strong> {{ Auth::user()->mail }}</p>
              <p><strong>Numéro de téléphone :</strong> {{ Auth::user()->phone }}</p>
              <p><strong>Date de naissance :</strong> {{ \Carbon\Carbon::parse(Auth::user()->dateNaiss)->format('d/m/Y') }}</p>
              <p><strong>Lieu de naissance :</strong> {{ Auth::user()->lieuNaiss }}</p>
              <p><strong>Adresse :</strong> {{ Auth::user()->adresse }}</p>
            </div>
          </div>
        </div>

        <div class="btn-box mb-4">
          <a href="{{route('profile.edit')}}" class="btn btn-secondary">Modifier mon profil</a>
          <a href="{{route('mes-favoris')}}" class="btn btn-primary">
           <i class="fas fa-heart"></i> Mes Recettes Favorites
        </a>
      
        </div>

        <!-- Section Mes Recettes -->
        <div class="recipes_section mt-5">
          <div class="d-flex justify-content-between align-items-center mb-4">
            <h3>Mes Recettes</h3>
            <button type="button" class="btn btn-primary w-auto px-5" data-bs-toggle="modal" data-bs-target="#addRecipeModal">
              Ajouter recette
            </button>
          </div>
         
          <!-- Liste des recettes -->
          <div class="row">
         @forelse(Auth::user()->recettes as $recette)
              <div class="col-md-6 mb-4">
                <div class="card">
                  @if($recette->image)
                    <img src="{{ asset('storage/' . $recette->image) }}" class="card-img-top" alt="{{ $recette->titre }}">
                  @endif
                  <div class="card-body">
                    <h5 class="card-title">{{ $recette->titre }}</h5>
                    <p class="card-text">{{ Str::limit($recette->description, 100) }}</p>
                    <div class="d-flex justify-content-between">
                      <a href="{{ route('recettes.show', $recette) }}" class="btn btn-info btn-sm">Voir</a>
                      <a href="{{ route('recettes.edit', $recette) }}" class="btn btn-warning btn-sm">Modifier</a>
                      <form action="{{ route('recettes.destroy', $recette) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette recette ?')">Supprimer</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            @empty
              <div class="col-12">
                <p class="text-center">Vous n'avez pas encore ajouté de recettes.</p>
              </div>
            @endforelse

          </div>
        </div>
      </div>
    </div>
  </div>
  <form action="{{ route('logout') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="btn btn-danger">Se déconnecter</button>
          </form>

  <!-- Modal Ajout de Recette -->
  <div class="modal fade" id="addRecipeModal" tabindex="-1" aria-labelledby="addRecipeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addRecipeModalLabel">Ajouter une nouvelle recette</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <form action="{{ route('recettes.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="titre" class="form-label">Titre de la recette</label>
                <input type="text" class="form-control @error('titre') is-invalid @enderror" 
                    id="titre" name="titre" required value="{{ old('titre') }}">
                @error('titre')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" 
                        id="description" name="description" rows="3">{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
    <label for="categories">Catégories</label>
          <select name="categories[]" id="categories" class="form-control select2" multiple>
              @foreach($categories as $categorie)
                  <option value="{{ $categorie->id }}" 
                      {{ isset($recette) && $recette->categories->contains($categorie->id) ? 'selected' : '' }}>
                      {{ $categorie->nom }}
                  </option>
              @endforeach
          </select>
      </div>
            
            <div class="mb-3">
                <label for="ingredient" class="form-label">Ingrédients</label>
                <textarea class="form-control @error('ingredient') is-invalid @enderror" 
                        id="ingredient" name="ingredient" rows="4" required>{{ old('ingredient') }}</textarea>
                @error('ingredient')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="instruction" class="form-label">Instructions</label>
                <textarea class="form-control @error('instruction') is-invalid @enderror" 
                        id="instruction" name="instruction" rows="4" required>{{ old('instruction') }}</textarea>
                @error('instruction')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="tempsPreparation" class="form-label">Temps de préparation (en minutes)</label>
                <input type="number" class="form-control @error('tempsPreparation') is-invalid @enderror" 
                    id="tempsPreparation" name="tempsPreparation" required value="{{ old('tempsPreparation') }}">
                @error('tempsPreparation')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="image" class="form-label">Image de la recette</label>
                <input type="file" class="form-control @error('image') is-invalid @enderror" 
                    id="image" name="image">
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="video" class="form-label">Lien vidéo (optionnel)</label>
                <input type="text" class="form-control @error('video') is-invalid @enderror" 
                    id="video" name="video" value="{{ old('video') }}">
                @error('video')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Ne pas inclure visiteur_id comme champ caché, on le gérera dans le contrôleur -->
            
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary">Ajouter la recette</button>
            </div>
        </form>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection

@section('scripts')
<script>
// Validation du formulaire côté client si nécessaire
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    form.addEventListener('submit', function(event) {
        // Ajoutez ici votre logique de validation si nécessaire
    });
});
</script>
@endsection