<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable;

  

    protected $fillable = [
        'nom',
        'prenom',
        'adresse',
        'role',
        'dateNaiss',
        'lieuNaiss',
        'mail',
        'photo',
        'phone',
        'password',
        'account_status'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'mail_verified_at' => 'datetime',
        'dateNaiss' => 'date',
    ];

    const ROLE_ADMIN = 'admin';
    const ROLE_VISITEUR = 'visiteur';

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    // Méthode corrigée pour garantir un retour string
    public function getUserName(): string
    {
        if (!empty($this->prenom) || !empty($this->nom)) {
            return trim($this->prenom . ' ' . $this->nom);
        }
        
        if (!empty($this->mail)) {
            return $this->mail;
        }
        
        return 'Utilisateur ' . $this->id;
    }

    // Vous pouvez aussi ajouter cette méthode si vous utilisez le name attribut
    public function getNameAttribute(): string
    {
        return $this->getUserName();
    }

    public function administrateur()
    {
        return $this->hasOne(Administrateur::class);
    }
    public function visiteur()
    {
        return $this->hasOne(visiteur::class);
    }

     /**
     * Relation avec Recettes via Visiteur
     */
    public function recettes()
    {
        return $this->hasManyThrough(
            Recette::class,
            Visiteur::class,
            'user_id', // Clé étrangère sur la table visiteur
            'visiteur_id', // Clé étrangère sur la table recettes
            'id', // Clé locale de users
            'id' // Clé locale de visiteur
        );
    }

    // Dans App\Models\User.php

// Dans app/Models/User.php
public function getPhotoUrl()
{
    if ($this->photo) {
        // Debug pour voir les chemins
        \Log::info('Photo path: ' . $this->photo);
        \Log::info('Full disk path: ' . Storage::disk('public')->path($this->photo));
        \Log::info('URL path: ' . Storage::disk('public')->url($this->photo));
        \Log::info('File exists: ' . (Storage::disk('public')->exists($this->photo) ? 'Yes' : 'No'));
        
        return Storage::disk('public')->url($this->photo);
    }
    return Storage::disk('public')->url('photos/pp.png');
}
// Dans votre modèle User, ajoutez cette méthode
public function deletePhoto()
{
    if ($this->photo && Storage::disk('public')->exists($this->photo)) {
        Storage::disk('public')->delete($this->photo);
        $this->update(['photo' => null]);
        return true;
    }
    return false;
}





}