<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;  

class Recette extends Model
{
    use HasFactory , SoftDeletes;

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
        'tempsPreparation',
         'deleted_by'

    ];

    protected $casts = [
        'dateCreation' => 'datetime',
        'heureCreation' => 'string', 
        'tempsPreparation' => 'integer'
    ];

    public function visiteur(): BelongsTo
    {
        return $this->belongsTo(Visiteur::class, 'visiteur_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Categorie::class);
    }

    public function aimes()
    {
        return $this->belongsToMany(Visiteur::class, 'aimes')
        ->withPivot('created_at') 
                    ->withTimestamps();
    }

    public function favories()
    {
        return $this->belongsToMany(Visiteur::class, 'favories')
        ->withPivot('created_at') 
                    ->withTimestamps();
    }

    public function commentaires()
    {
        return $this->hasMany(Commentaire::class);
    }

    public function user(): BelongsTo
    {
        return $this->visiteur->user();
    }

}
