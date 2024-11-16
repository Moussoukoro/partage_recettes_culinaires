<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;  

class Recette extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'description',
        'ingredient',
        'instruction',
        'image',
        'video',
        'dateCreation',
        'heureCreation',
        'visiteur_id',
        'tempsPreparation'
    ];

    protected $casts = [
        'dateCreation' => 'datetime',
        'heureCreation' => 'string', 
        'tempsPreparation' => 'integer'
    ];

    /**
     * Obtenir le visiteur qui a créé la recette
     */
    public function visiteur(): BelongsTo
    {
        return $this->belongsTo(Visiteur::class, 'visiteur_id');
    }
    public function categories()
    {
        return $this->belongsToMany(Categorie::class);
    }
      /**
     * Obtenir l'utilisateur qui a créé la recette via le visiteur
     */
    public function user(): BelongsTo
    {
        return $this->visiteur->user(); // Utiliser la relation définie dans Visiteur
    }
    


}
