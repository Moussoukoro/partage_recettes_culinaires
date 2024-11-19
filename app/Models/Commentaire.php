<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Commentaire extends Model
{
    use HasFactory;

    protected $fillable = [
        'contenu',
        'visiteur_id',
        'recette_id'
    ];

    /**
     * Get the visiteur that owns the comment.
     */
    public function visiteur(): BelongsTo
    {
        return $this->belongsTo(Visiteur::class);
    }

    /**
     * Get the recette that owns the comment.
     */
    public function recette(): BelongsTo
    {
        return $this->belongsTo(Recette::class);
    }
}