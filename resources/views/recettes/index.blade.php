@extends('layouts.entete')

@section('content')
<div class="container py-5">
    <h1 class="text-center mb-4">Découvrez Nos Délicieuses Recettes</h1>

    <div class="row">
        @forelse ($recettes as $recette)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm hover-shadow">
                    @if($recette->image)
                        <img src="{{ asset('storage/' . $recette->image) }}" 
                             class="card-img-top" 
                             alt="{{ $recette->titre }}" 
                             style="height: 200px; object-fit: cover;">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $recette->titre }}</h5>
                        <p class="card-text text-muted mb-2">
                            <i class="fas fa-clock"></i> {{ $recette->tempsPreparation }} min
                        </p>
                        <p class="card-text">{{ Str::limit($recette->description, 100) }}</p>

                        <!-- Catégories -->
                        <div class="mb-2">
                            @foreach($recette->categories as $categorie)
                                <span class="badge bg-secondary me-1">{{ $categorie->nom }}</span>
                            @endforeach
                        </div>

                       <!-- Interactions -->
<div class="d-flex justify-content-between align-items-center mb-3">
    <!-- Likes -->
    <button class="btn btn-sm {{ Auth::check() && $recette->aimes->contains(Auth::user()->visiteur->id) ? 'btn-primary' : 'btn-outline-primary' }}" 
            onclick="aimer({{ $recette->id }})">
        <i class="{{ Auth::check() && $recette->aimes->contains(Auth::user()->visiteur->id) ? 'fas' : 'far' }} fa-heart"></i>
        <span id="likes-count-{{ $recette->id }}">{{ $recette->aimes()->count() }}</span>
    </button>

    <!-- Favoris -->
    <button class="btn btn-sm {{ Auth::check() && $recette->favories->contains(Auth::user()->visiteur->id) ? 'btn-warning' : 'btn-outline-warning' }}" 
            onclick="ajouterFavori({{ $recette->id }})">
        <i class="{{ Auth::check() && $recette->favories->contains(Auth::user()->visiteur->id) ? 'fas' : 'far' }} fa-star"></i>
        <span id="favoris-count-{{ $recette->id }}">{{ $recette->favories()->count() }}</span>
    </button>

                            <!-- Commentaires -->
                            <button class="btn btn-sm {{ Auth::check() && $recette->commentaires->where('visiteur_id', Auth::user()->visiteur->id)->count() > 0 ? 'btn-secondary' : 'btn-outline-secondary' }}" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#commentModal-{{ $recette->id }}">
                                <i class="{{ Auth::check() && $recette->commentaires->where('visiteur_id', Auth::user()->visiteur->id)->count() > 0 ? 'fas' : 'far' }} fa-comment"></i>
                                <span id="comments-count-{{ $recette->id }}">{{ $recette->commentaires()->count() }}</span>
                            </button>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                Par {{ $recette->visiteur->nomUtilisateur }}
                            </small>
                            <small class="text-muted">
                            {{ $recette->created_at->diffForHumans() }}
                            </small>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent">
                        <a href="{{ route('recettes.show', $recette) }}" 
                           class="btn btn-primary w-100">
                            Voir la recette
                        </a>
                    </div>
                </div>
            </div>

            <!-- Modal Commentaires -->
            <div class="modal fade" id="commentModal-{{ $recette->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Commentaires - {{ $recette->titre }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Liste des commentaires -->
                            <div class="comments-list mb-3">
                         
                            @foreach($recette->commentaires()->whereNull('parent_id')->get() as $commentaire)
                                <div class="comment-item mb-2 p-2 border-bottom">
                                    <div class="d-flex justify-content-between">
                                        <strong>{{ $commentaire->visiteur->nomUtilisateur }}</strong>
                                        <small>{{ $commentaire->created_at->diffForHumans() }}</small>
                                    </div>
                                    <p class="mb-0">{{ $commentaire->contenu }}</p>
                                    
                                    <!-- Bouton Répondre -->
                                    <button class="btn btn-sm btn-outline-secondary mt-2" 
                                            onclick="showReplyForm({{ $commentaire->id }})">
                                        Répondre
                                    </button>

                                    <!-- Formulaire de réponse -->
                                    <form action="{{ route('commentaires.store') }}" 
                                        method="POST" 
                                        class="reply-form mt-2" 
                                        id="replyForm-{{ $commentaire->id }}" 
                                        style="display: none;">
                                        @csrf
                                        <input type="hidden" name="recette_id" value="{{ $recette->id }}">
                                        <input type="hidden" name="parent_id" value="{{ $commentaire->id }}">
                                        <div class="form-group">
                                            <textarea class="form-control" 
                                                    name="contenu" 
                                                    rows="3" 
                                                    placeholder="Votre réponse..."></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary mt-2">
                                            Envoyer
                                        </button>
                                    </form>

                                    <!-- Affichage des réponses -->
                                    @foreach($commentaire->replies as $reply)
                                        <div class="comment-reply ml-4 mt-2 p-2 bg-light">
                                            <div class="d-flex justify-content-between">
                                                <strong>{{ $reply->visiteur->nomUtilisateur }}</strong>
                                                <small>{{ $reply->created_at->diffForHumans() }}</small>
                                            </div>
                                            <p class="mb-0">{{ $reply->contenu }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                            </div>

                            <!-- Formulaire de commentaire -->
                            <form action="{{ route('commentaires.store') }}" method="POST" class="comment-form">
                                @csrf
                                <input type="hidden" name="recette_id" value="{{ $recette->id }}">
                                <div class="form-group">
                                    <textarea class="form-control" 
                                              name="contenu" 
                                              rows="3" 
                                              placeholder="Votre commentaire..."></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary mt-2">
                                    Commenter
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    Aucune recette n'a été publiée pour le moment.
                </div>
            </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $recettes->links() }}
    </div>
</div>
@push('scripts')
<script>

// Show/hide reply form
function showReplyForm(commentId) {
    const replyForm = document.getElementById(`replyForm-${commentId}`);
    replyForm.style.display = replyForm.style.display === 'none' ? 'block' : 'none';
}

// Bind reply buttons
function bindReplyButtons() {
    document.querySelectorAll('[onclick^="showReplyForm"]').forEach(button => {
        button.setAttribute('aria-label', 'Répondre au commentaire');
    });
}

// Handle comment submission
function handleCommentSubmit(e) {
    e.preventDefault();
    const form = e.target;
    const formData = new FormData(form);
    const recetteId = formData.get('recette_id');
    const textarea = form.querySelector('textarea');

    // Basic validation
    if (!textarea.value.trim()) {
        alert('Veuillez saisir un commentaire.');
        return;
    }
    
    axios.post('/commentaires', formData)
        .then(response => {
            // Reset form and hide it if it's a reply form
            form.reset();
            if (form.classList.contains('reply-form')) {
                form.style.display = 'none';
            }
            
            // Update comment count and button state
            updateCommentButton(recetteId, response.data.count);
            
            // Add new comment/reply to list
            addNewComment(recetteId, response.data.commentaire, formData.get('parent_id'));
        })
        .catch(error => {
            console.error('Erreur:', error);
            if (error.response?.status === 401) {
                alert('Vous devez être connecté pour commenter.');
            } else {
                alert('Une erreur est survenue lors de l\'ajout du commentaire.');
            }
        });
}

// Update comment button state
function updateCommentButton(recetteId, count) {
    const button = document.querySelector(`button[data-bs-target="#commentModal-${recetteId}"]`);
    const icon = button.querySelector('i');
    const countSpan = document.getElementById(`comments-count-${recetteId}`);
    
    countSpan.innerText = count;
    button.classList.remove('btn-outline-secondary');
    button.classList.add('btn-secondary');
    icon.classList.remove('far');
    icon.classList.add('fas');
}

// Add new comment to the list
function addNewComment(recetteId, commentaire, parentId) {
    const commentsList = document.querySelector(`#commentModal-${recetteId} .comments-list`);
    
    if (parentId) {
        // It's a reply
        const parentComment = document.querySelector(`#replyForm-${parentId}`).closest('.comment-item');
        const repliesContainer = parentComment.querySelector('.comment-replies') || 
            parentComment.appendChild(document.createElement('div'));
        
        repliesContainer.classList.add('comment-replies');
        repliesContainer.insertAdjacentHTML('beforeend', createReplyHTML(commentaire));
    } else {
        // It's a main comment
        commentsList.insertAdjacentHTML('afterbegin', createMainCommentHTML(recetteId, commentaire));
    }

    // Rebind event listeners
    bindReplyButtons();
    bindCommentForms();
}

// HTML template for reply
function createReplyHTML(commentaire) {
    return `
        <div class="comment-reply ml-4 mt-2 p-2 bg-light">
            <div class="d-flex justify-content-between">
                <strong>${commentaire.nomUtilisateur}</strong>
                <small>À l'instant</small>
            </div>
            <p class="mb-0">${commentaire.contenu}</p>
        </div>
    `;
}

// HTML template for main comment
function createMainCommentHTML(recetteId, commentaire) {
    return `
        <div class="comment-item mb-2 p-2 border-bottom">
            <div class="d-flex justify-content-between">
                <strong>${commentaire.nomUtilisateur}</strong>
                <small>À l'instant</small>
            </div>
            <p class="mb-0">${commentaire.contenu}</p>
            
            <button class="btn btn-sm btn-outline-secondary mt-2 btn-reply" 
                    onclick="showReplyForm(${commentaire.id})">
                Répondre
            </button>

            <form action="{{ route('commentaires.store') }}" 
                method="POST" 
                class="reply-form mt-2" 
                id="replyForm-${commentaire.id}" 
                style="display: none;">
                @csrf
                <input type="hidden" name="recette_id" value="${recetteId}">
                <input type="hidden" name="parent_id" value="${commentaire.id}">
                <div class="form-group">
                    <textarea class="form-control" 
                            name="contenu" 
                            rows="3" 
                            placeholder="Votre réponse..."></textarea>
                </div>
                <button type="submit" class="btn btn-primary mt-2">
                    Envoyer
                </button>
            </form>

            <div class="comment-replies"></div>
        </div>
    `;
}

// Initialize event bindings
document.addEventListener('DOMContentLoaded', function() {
    bindReplyButtons();
    bindCommentForms();
});

// Bind comment forms
function bindCommentForms() {
    document.querySelectorAll('.comment-form, .reply-form').forEach(form => {
        form.removeEventListener('submit', handleCommentSubmit);
        form.addEventListener('submit', handleCommentSubmit);
    });
}
</script>
@endpush


@push('styles')
<style>
.hover-shadow:hover {
    transform: translateY(-5px);
    transition: transform 0.3s ease;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important;
}

.card {
    transition: all 0.3s ease;
}

.badge {
    font-size: 0.8em;
}

.comment-item {
    background-color: #f8f9fa;
    border-radius: 4px;
}
.comment-reply {
    border-left: 3px solid #dee2e6;
    margin-left: 20px;
}
</style>
@endpush

@endsection