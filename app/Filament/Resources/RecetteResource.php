<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RecetteResource\Pages;
use App\Models\Recette;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Support\Enums\FontWeight;
use Filament\Infolists\Infolist;

class RecetteResource extends Resource
{
    protected static ?string $model = Recette::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    
    protected static ?string $navigationLabel = 'Recettes';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('titre')
                    ->searchable()
                    ->sortable(),
                    
                TextColumn::make('description')
                    ->limit(50)
                    ->searchable(),
                    
                ImageColumn::make('image')
                    ->circular()
                    ->width(50),
                    
                TextColumn::make('dateCreation')
                    ->dateTime()
                    ->sortable(),
                    
                TextColumn::make('tempsPreparation')
                    ->numeric()
                    ->suffix(' minutes')
                    ->sortable(),
                    
                TextColumn::make('visiteur.user.nom')
                    ->label('Créé par')
                    ->searchable(),
            ])
            ->defaultSort('dateCreation', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('user')
                    ->relationship('visiteur.user', 'nom')
                    ->label('Filtrer par créateur'),
                    
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from'),
                        Forms\Components\DatePicker::make('created_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('dateCreation', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('dateCreation', '<=', $date),
                            );
                    })
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('Voir')
                    ->modalHeading(fn (Recette $record): string => "Détails de la recette : {$record->titre}")
                    ->form([
                        Forms\Components\Group::make()
                            ->schema([
                                Forms\Components\ViewField::make('image')
                                    ->view('filament.forms.components.image-view'),

                                Forms\Components\TextInput::make('titre')
                                    ->label('Titre')
                                    ->disabled(),

                                Forms\Components\Textarea::make('description')
                                    ->label('Description')
                                    ->disabled()
                                    ->columnSpanFull(),

                                Forms\Components\Textarea::make('ingredient')
                                    ->label('Ingrédients')
                                    ->disabled()
                                    ->columnSpanFull(),

                                Forms\Components\Textarea::make('instruction')
                                    ->label('Instructions')
                                    ->disabled()
                                    ->columnSpanFull(),

                                Forms\Components\TextInput::make('tempsPreparation')
                                    ->label('Temps de préparation')
                                    ->suffix('minutes')
                                    ->disabled(),

                                    Forms\Components\TextInput::make('visiteur_name')
                                    ->label('Créé par')
                                    ->disabled()
                                    ->formatStateUsing(function ($record) {
                                        return $record->visiteur?->user?->nom ?? 'Non défini';
                                    }),

                                Forms\Components\DateTimePicker::make('dateCreation')
                                    ->label('Date de création')
                                    ->disabled(),

                                Forms\Components\TextInput::make('heureCreation')
                                    ->label('Heure de création')
                                    ->disabled(),

                                 // Remplacez le TagsInput par :
                                 Forms\Components\Section::make('Catégories')
                                 ->schema([
                                     Forms\Components\View::make('categories')
                                         ->view('filament.forms.components.categories-view')
                                 ]),

                                Forms\Components\TextInput::make('video')
                                    ->label('Lien vidéo')
                                    ->disabled()
                                    ->url()
                                    ->visible(fn ($record) => !empty($record->video)),
                            ])
                            ->columns(2)
                    ]),
                    
                Tables\Actions\DeleteAction::make()
                    ->label('Supprimer')
                    ->modalHeading('Supprimer la recette')
                    ->modalDescription('Êtes-vous sûr de vouloir supprimer cette recette ? Cette action est irréversible.'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Supprimer la sélection'),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRecettes::route('/'),
            'create' => Pages\CreateRecette::route('/create'),
            'edit' => Pages\EditRecette::route('/{record}/edit'),
        ];
    }
}