<?php

namespace App\Filament\Resources\CommentaireResource\Pages;

use App\Filament\Resources\CommentaireResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCommentaire extends EditRecord
{
    protected static string $resource = CommentaireResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
