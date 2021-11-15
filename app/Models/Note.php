<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Note extends Pivot
{
    use HasFactory;

    public $timestamps = ["created_at"]; //only want to used created_at column
    public const UPDATED_AT = null; //and updated by default null set

    protected $guarded = ['id'];

    protected $casts = [
        'is_completed' => 'boolean',
        'completed_at' => 'datetime',
    ];
}
