{{-- resources/views/recettes/edit.blade.php --}}
@extends('layouts.entete')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="mb-0">Modifier la recette</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('recettes.update', $recette) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="titre" class="form-label">Titre de la recette *</label>
                            <input type="text" class="form-control @error('titre') is-invalid @enderror" 
                                   id="titre" name="titre" value="{{ old('titre', $recette->titre) }}" required>
                            @error('titre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="3">{{ old('description', $recette->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="categories" class="form-label">Catégories</label>
                            <select name="categories[]" id="categories" class="form-control select2" multiple>
                                @foreach($categories as $categorie)
                                    <option value="{{ $categorie->id }}" 
                                        {{ (in_array($categorie->id, old('categories', $recette->categories->pluck('id')->toArray()))) ? 'selected' : '' }}>
                                        {{ $categorie->nom }}
                                    </option>
                                @endforeach
                            </select>
                            @error('categories')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="ingredient" class="form-label">Ingrédients *</label>
                            <textarea class="form-control @error('ingredient') is-invalid @enderror" 
                                      id="ingredient" name="ingredient" rows="5" required>{{ old('ingredient', $recette->ingredient) }}</textarea>
                            @error('ingredient')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="instruction" class="form-label">Instructions *</label>
                            <textarea class="form-control @error('instruction') is-invalid @enderror" 
                                      id="instruction" name="instruction" rows="5" required>{{ old('instruction', $recette->instruction) }}</textarea>
                            @error('instruction')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tempsPreparation" class="form-label">Temps de préparation (en minutes) *</label>
                            <input type="number" class="form-control @error('tempsPreparation') is-invalid @enderror" 
                                   id="tempsPreparation" name="tempsPreparation" 
                                   value="{{ old('tempsPreparation', $recette->tempsPreparation) }}" required min="1">
                            @error('tempsPreparation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Image de la recette</label>
                            @if($recette->image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $recette->image) }}" 
                                         alt="Image actuelle" class="img-thumbnail" style="max-height: 200px;">
                                    <p class="text-muted">Image actuelle</p>
                                </div>
                            @endif
                            <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                   id="image" name="image" accept="image/*">
                            <small class="text-muted">Laissez vide pour conserver l'image actuelle</small>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="video" class="form-label">Lien vidéo (YouTube, Vimeo, etc.)</label>
                            <input type="url" class="form-control @error('video') is-invalid @enderror" 
                                   id="video" name="video" value="{{ old('video', $recette->video) }}" 
                                   placeholder="https://www.youtube.com/watch?v=...">
                            @error('video')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                            <a href="{{ route('recettes.show', $recette) }}" class="btn btn-secondary">Annuler</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialisation de Select2
    $('.select2').select2({
        placeholder: 'Sélectionnez les catégories',
        allowClear: true
    });
});
</script>
@endsection