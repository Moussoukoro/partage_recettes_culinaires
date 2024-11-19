<?php

namespace App\Filament\Resources\RecetteResource\Pages;

use App\Filament\Resources\RecetteResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRecettes extends ListRecords
{
    protected static string $resource = RecetteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
