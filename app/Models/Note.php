<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
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
     * Get the user who owns the note
     *
     * @return BelongsToMany
     */
    public function user(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }


    /**
     * Get the note images
     *
     * @return HasMany
     */
    public function images(): HasMany
    {
        return $this->hasMany(NoteImage::class);
    }


    /**
     * Change is complete status to the opposite
     */
    public function changeCheckedStatus()
    {
        $this->is_completed = !$this->is_completed;
        $this->save();
    }
}
