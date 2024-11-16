@extends('layouts.entete')

@section('content')
<section class="recipe_list_section layout_padding">
    <div class="container">
        <div class="heading_container heading_center">
            <h2>Nos Recettes</h2>
        </div>

        <!-- Liste des recettes -->
        <div class="row">
            @for ($i = 1; $i <= 6; $i++)
            <div class="col-md-4 mb-4">
                <div class="recipe-card">
                    <img src="https://via.placeholder.com/400x200?text=Recette+{{ $i }}" 
                         class="recipe-image" alt="Recette {{ $i }}">
                    
                    <div class="recipe-content">
                        <span class="difficulty facile">
                            Facile
                        </span>
                        <h4>Recette {{ $i }}</h4>
                        <p class="text-muted">Par Auteur {{ $i }}</p>
                        
                        <!-- Note moyenne -->
                        <div class="rating mb-2">
                            @for($j = 1; $j <= 5; $j++)
                                <i class="fa {{ $j <= 4 ? 'fa-star' : 'fa-star-o' }}"></i>
                            @endfor
                            <span class="text-muted">(4.0/5)</span>
                        </div>
                    </div>

                    <!-- Statistiques -->
                    <div class="recipe-stats">
                        <div class="recipe-stat">
                            <i class="fa fa-clock-o"></i>
                            <span>30 min</span>
                        </div>
                        <div class="recipe-stat">
                            <i class="fa fa-users"></i>
                            <span>4 pers.</span>
                        </div>
                        <div class="recipe-stat">
                            <i class="fa fa-comment"></i>
                            <span>12</span>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="recipe-actions">
                        <button type="button" class="btn-action" title="Ajouter aux favoris">
                            <i class="fa fa-heart-o"></i>
                        </button>
                        <button type="button" class="btn-action" title="Commenter">
                            <i class="fa fa-comment-o"></i>
                        </button>
                        <button type="button" class="btn-action" title="Noter">
                            <i class="fa fa-star-o"></i>
                        </button>
                    </div>
                </div>
            </div>
            @endfor
        </div>
    </div>
</section>

@push('styles')
<style>
    .recipe-card {
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        margin-bottom: 25px;
        background: white;
        transition: transform 0.3s ease;
    }
    
    .recipe-card:hover {
        transform: translateY(-5px);
    }

    .recipe-image {
        height: 200px;
        object-fit: cover;
        width: 100%;
    }

    .btn-action {
        background: none;
        border: none;
        padding: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-action:hover {
        color: #f7941d;
    }

    .difficulty {
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 0.8em;
    }

    .difficulty.facile { background-color: #d4edda; color: #155724; }
</style>
@endpush
@endsection
