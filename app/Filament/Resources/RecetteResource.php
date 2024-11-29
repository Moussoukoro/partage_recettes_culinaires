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
use Illuminate\Database\Eloquent\Collection;

class RecetteResource extends Resource
{
    protected static ?string $model = Recette::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Recettes';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('titre')
                    ->required()
                    ->maxLength(255),
                    
                Forms\Components\Textarea::make('description')
                    ->required(),
                    
                Forms\Components\ViewField::make('image')
                    ->view('filament.forms.components.recette-image-view'),
                    
                Forms\Components\DateTimePicker::make('dateCreation'),
                    
                Forms\Components\TextInput::make('tempsPreparation')
                    ->numeric()
                    ->suffix('minutes'),
                    
                Forms\Components\Textarea::make('ingredient')
                    ->required(),
                    
                Forms\Components\Textarea::make('instruction')
                    ->required(),
                    
                Forms\Components\TextInput::make('video')
                    ->url(),
            ]);
    }

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
                    Tables\Columns\ViewColumn::make('image')
                    ->label('image')
                    ->view('filament.forms.components.recette-image-view'), 
                    
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
                                    ->disabled(),
                                Forms\Components\Textarea::make('description')
                                    ->disabled()
                                    ->columnSpanFull(),
                                Forms\Components\Textarea::make('ingredient')
                                    ->disabled()
                                    ->columnSpanFull(),
                                Forms\Components\Textarea::make('instruction')
                                    ->disabled()
                                    ->columnSpanFull(),
                                Forms\Components\TextInput::make('tempsPreparation')
                                    ->suffix('minutes')
                                    ->disabled(),
                                Forms\Components\TextInput::make('visiteur_name')
                                    ->label('Créé par')
                                    ->disabled()
                                    ->formatStateUsing(fn ($record) => $record->visiteur?->user?->nom ?? 'Non défini'),
                                Forms\Components\DateTimePicker::make('dateCreation')
                                    ->disabled(),
                                Forms\Components\Section::make('Catégories')
                                    ->schema([
                                        Forms\Components\View::make('categories')
                                            ->view('filament.forms.components.categories-view')
                                    ]),
                                Forms\Components\TextInput::make('video')
                                    ->disabled()
                                    ->url()
                                    ->visible(fn ($record) => !empty($record->video)),
                            ])
                            ->columns(2)
                    ]),
                Tables\Actions\DeleteAction::make()
                    ->label('Supprimer')
                    ->modalHeading('Supprimer la recette')
                    ->modalDescription('Êtes-vous sûr de vouloir supprimer cette recette ? Cette action est irréversible.')
                    ->before(function (Recette $record) {
                        $record->deleted_by = auth()->id();
                        $record->save();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                    ->label('Supprimer la sélection')
                    ->before(function (Collection $records) {
                        $records->each(function ($record) {
                            $record->deleted_by = auth()->id();
                            $record->save();
                        });
                    }),
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