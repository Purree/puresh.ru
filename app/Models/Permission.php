<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Schema;

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
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'user_id'
    ];


    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_admin' => 'boolean',
        'notes' => 'boolean',
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
     * Get names of all columns (except user_id)
     */
    public static function getAll(): array
    {
        define("App\Models\INVISIBLE_COLS", ['user_id', 'id']);
        // Get all column names
        $columnList = Schema::getColumnListing('permissions');
        // Delete user_id from columns
        return array_diff($columnList, INVISIBLE_COLS);
    }
}
