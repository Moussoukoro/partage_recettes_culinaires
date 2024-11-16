@extends('layouts.entete')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="mb-0">Créer une nouvelle recette</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('recettes.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="titre" class="form-label">Titre de la recette *</label>
                            <input type="text" class="form-control @error('titre') is-invalid @enderror" 
                                   id="titre" name="titre" value="{{ old('titre') }}" required>
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
                            <label for="ingredient" class="form-label">Ingrédients *</label>
                            <textarea class="form-control @error('ingredient') is-invalid @enderror" 
                                      id="ingredient" name="ingredient" rows="5" required>{{ old('ingredient') }}</textarea>
                            @error('ingredient')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="instruction" class="form-label">Instructions *</label>
                            <textarea class="form-control @error('instruction') is-invalid @enderror" 
                                      id="instruction" name="instruction" rows="5" required>{{ old('instruction') }}</textarea>
                            @error('instruction')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tempsPreparation" class="form-label">Temps de préparation (en minutes) *</label>
                            <input type="number" class="form-control @error('tempsPreparation') is-invalid @enderror" 
                                   id="tempsPreparation" name="tempsPreparation" value="{{ old('tempsPreparation') }}" required min="1">
                            @error('tempsPreparation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Image de la recette</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                   id="image" name="image" accept="image/*">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="video" class="form-label">Lien vidéo (YouTube, Vimeo, etc.)</label>
                            <input type="url" class="form-control @error('video') is-invalid @enderror" 
                                   id="video" name="video" value="{{ old('video') }}" 
                                   placeholder="https://www.youtube.com/watch?v=...">
                            @error('video')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Créer la recette</button>
                            <a href="{{ route('mes-recettes') }}" class="btn btn-secondary">Annuler</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
