<div class="grid grid-cols-2 gap-4">
    @forelse($getRecord()->categories as $categorie)
        <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg">
            @if($categorie->photo)
            <img src="{{ asset('storage/' . $categorie->photo) }}" class="w-16 h-16 rounded-full object-cover" alt="{{ $categorie->nom }}">
            @else
                <img src="{{ asset('images/default.png') }}" class="w-16 h-16 rounded-full object-cover" alt="Image par défaut">
            @endif
            <span class="font-medium">{{ $categorie->nom ?? 'Nom non défini' }}</span>
        </div>
    @empty
        <p>Aucune catégorie associée.</p>
    @endforelse
</div>
