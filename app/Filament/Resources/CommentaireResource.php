<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CommentaireResource\Pages;
use App\Filament\Resources\CommentaireResource\RelationManagers;
use App\Models\Commentaire;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CommentaireResource extends Resource
{
    protected static ?string $model = Commentaire::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('contenu')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('visiteur_id')
                    ->relationship('visiteur', 'nom')
                    ->required(),
                Forms\Components\Select::make('recette_id')
                    ->relationship('recette', 'titre')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('contenu')
                    ->searchable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('visiteur.user.nom')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('recette.titre')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make()
                ->label('Supprimer')
                ->modalHeading('Supprimer la recette')
                ->modalDescription('Êtes-vous sûr de vouloir supprimer cette recette ? Cette action est irréversible.')
                ->before(function (Commentaire $record) {
                    $record->deleted_by = auth()->id();
                    $record->save();
                }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                    ->label('Supprimer la sélection')
                    ->before(function (Collection $records) {
                        $records->each(function ($record) {
                            $record->deleted_by = auth()->id();
                            $record->save();
                        });
                    }),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCommentaires::route('/'),
            'create' => Pages\CreateCommentaire::route('/create'),
            'view' => Pages\ViewCommentaire::route('/{record}'),
            'edit' => Pages\EditCommentaire::route('/{record}/edit'),
        ];
    }
}