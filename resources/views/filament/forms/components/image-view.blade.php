<div class="w-full">
    @if($getState())
        <img src="{{ asset('storage/' . $getState()) }}" alt="Image de la recette" class="max-w-full h-auto rounded-lg">
    @else
        <p class="text-gray-500">Aucune image disponible</p>
    @endif
</div>