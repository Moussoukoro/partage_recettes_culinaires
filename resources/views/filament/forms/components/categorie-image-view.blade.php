@php
    $record = $getRecord() ?? null;
    $state = $getState() ?? null;
@endphp

@if($record && $record->photo)
    <img src="{{ asset('storage/' . $record->photo) }}" 
         class="w-32 h-32 rounded-full object-cover" 
         alt="{{ $record->nom }}">
@elseif($state)
    <img src="{{ asset('storage/' . $state) }}" 
         class="w-32 h-32 rounded-full object-cover" 
         alt="Image catégorie">
@else
    <img src="{{ asset('images/default.png') }}" 
         class="w-32 h-32 rounded-full object-cover" 
         alt="Image par défaut">
@endif