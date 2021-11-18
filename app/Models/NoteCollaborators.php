<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NoteCollaborators extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $guarded = ['id'];

    /**
     * Get the note collaborator
     *
     * @return BelongsTo
     */
    public function collaborator(): BelongsTo
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the note id
     *
     * @return BelongsTo
     */
    public function note(): BelongsTo
    {
        return $this->belongsTo('App\Note');
    }

}
