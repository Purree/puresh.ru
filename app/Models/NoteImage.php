<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class NoteImage extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $guarded = [];

    /**
     * Get the notes who owns the image
     *
     * @return BelongsToMany
     */
    public function note(): BelongsToMany
    {
        return $this->belongsToMany(Note::class);
    }
}


