<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Note extends Model
{
    use HasFactory;

    public $timestamps = ["created_at"]; // only want to used created_at column
    public const UPDATED_AT = null; // and updated by default null set

    protected $guarded = ['id'];

    protected $table = 'notes';

    protected $casts = [
        'is_completed' => 'boolean',
        'created_at' => 'timestamp',
        'completed_at' => 'timestamp',
    ];


    /**
     * Get the user who owns the permissions
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo('App\User');
    }


    /**
     * Get user collaborators.
     */
    public function collaborators(): HasMany
    {
        return $this->hasMany(NoteCollaborators::class);
    }
}
