<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{
    use HasFactory;

    /**
     * Delete timestamps from Creat method
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are not mass assignable.
     *
     * @var string[]
     */
    protected $guarded = ['id'];

    /**
     * Get the user who owns the permissions
     *
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany('App\User');
    }

    /**
     * Get names of all permissions
     */
    public static function getAll(): array
    {
        return self::all('name')->pluck('name')->toArray();
    }
}
