<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Form;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Actions\BulkActionGroup;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('prenom')
                    ->label('Prénom')
                    ->required()
                    ->maxLength(255),
                TextInput::make('nom')
                    ->label('Nom')
                    ->required()
                    ->maxLength(255),
                TextInput::make('mail')    // Changé en 'mail'
                    ->label('Email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                Select::make('role')
                    ->label('Rôle')
                    ->options([
                        User::ROLE_ADMIN => 'Admin',
                        User::ROLE_VISITEUR => 'Visiteur',
                    ])
                    ->required(),
                TextInput::make('phone')
                    ->label('Téléphone')
                    ->tel()
                    ->nullable(),
                    FileUpload::make('photo')
                ->label('Photo')
                ->image()
                ->disk('public')
                ->directory('photos')
                ->visibility('public')
                ->maxSize(5120)
                ->imageResizeMode('contain')
                ->imageCropAspectRatio('1:1')
                ->imageResizeTargetWidth(200)
                ->imageResizeTargetHeight(200)
                ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/gif'])
                ->loadingIndicatorPosition('left')
                ->removeUploadedFileButtonPosition('right')
                ->uploadProgressIndicatorPosition('left')
                ->openable() // Permet d'ouvrir l'image en grand
                ->downloadable() // Permet de télécharger l'image
                ->previewable() // Permet de prévisualiser l'image
                ->nullable(),
                TextInput::make('adresse')
                    ->label('Adresse')
                    ->nullable()
                    ->maxLength(255),
                DatePicker::make('dateNaiss')
                    ->label('Date de naissance')
                    ->nullable()
                    ->format('Y-m-d'),
                TextInput::make('lieuNaiss')
                    ->label('Lieu de naissance')
                    ->nullable()
                    ->maxLength(255),
                TextInput::make('password')
                    ->label('Mot de passe')
                    ->password()
                    ->required(fn ($livewire) => $livewire instanceof Pages\CreateUser)
                    ->dehydrated(fn ($state) => filled($state))
                    ->dehydrateStateUsing(fn ($state) => bcrypt($state)),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('prenom')
                    ->label('Prénom')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nom')
                    ->label('Nom')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('mail')    // Changé en 'mail'
                    ->label('Email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('role')
                    ->label('Rôle')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'admin' => 'success',
                        'visiteur' => 'warning',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Téléphone'),
                    Tables\Columns\ImageColumn::make('photo')
                ->label('Photo')
                ->disk('public')
                ->circular()
                ->defaultImageUrl('/storage/photos/pp.png') // Image par défaut
                ->size(40)
                ->url(fn ($record) => Storage::url($record->photo)),  // Essaie avec Storage::url() si Storage::disk('public')->url() ne fonctionne pas

                Tables\Columns\TextColumn::make('dateNaiss')
                    ->label('Date de naissance')
                    ->date('d/m/Y'),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
