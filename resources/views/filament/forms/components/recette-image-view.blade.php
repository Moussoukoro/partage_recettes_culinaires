@php
    // On récupère le getRecord() si disponible, sinon on utilise null
    $recette = $getRecord() ?? null;
@endphp

@if($recette && $recette->image)
    <img src="{{ asset('storage/' . $recette->image) }}" 
         class="w-32 h-32 rounded-full object-cover" 
         alt="{{ $recette->titre ?? 'Image de la recette' }}" >
@else
    <img src="{{ asset('images/default.png') }}" 
         class="w-32 h-32 rounded-full object-cover" 
         alt="Image par défaut">
@endif