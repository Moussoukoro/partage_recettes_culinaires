<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Commentaire extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'contenu',
        'visiteur_id',
        'recette_id',
        'deleted_by',
        'parent_id' 

    ];
    public function parent()
    {
        return $this->belongsTo(Commentaire::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(Commentaire::class, 'parent_id');
    }

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