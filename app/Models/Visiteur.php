<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visiteur extends Model
{
    use HasFactory;
    protected $fillable = [
        'nomUtilisateur',
        'user_id',
    ];
 

   // Relation avec l'utilisateur
   public function user(): BelongsTo
   {
       return $this->belongsTo(User::class);
   }

   // Recettes créées par le visiteur
   public function recettes(): HasMany
   {
       return $this->hasMany(Recette::class);
   }

   // Recettes aimées par le visiteur
   public function recettesAimees(): BelongsToMany
   {
       return $this->belongsToMany(Recette::class, 'aimes')
       ->withPivot('created_at') 
                   ->withTimestamps();
   }

   // Recettes mises en favori
   public function recettesFavories(): BelongsToMany
   {
       return $this->belongsToMany(Recette::class, 'favories')
                    ->withPivot('created_at')  // Si vous voulez accéder à la date de création
                   ->withTimestamps();
   }

   // Commentaires du visiteur
   public function commentaires(): HasMany
   {
       return $this->hasMany(Commentaire::class);
   }

   // Recettes commentées
   public function recettesCommentees(): BelongsToMany
   {
       return $this->belongsToMany(Recette::class, 'commentaires')
                   ->withPivot(['contenu', 'created_at'])
                   ->withTimestamps();
   }


}
