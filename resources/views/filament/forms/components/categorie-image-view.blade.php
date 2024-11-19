@php
    // On récupère le getRecord() si disponible, sinon on utilise null
    $categorie = $getRecord() ?? null;
@endphp

@if($categorie && $categorie->photo)
    <img src="{{ asset('storage/' . $categorie->photo) }}" 
         class="w-32 h-32 rounded-full object-cover" 
         alt="{{ $categorie->nom }}">
@else
    <img src="{{ asset('images/default.png') }}" 
         class="w-32 h-32 rounded-full object-cover" 
         alt="Image par défaut">
@endif