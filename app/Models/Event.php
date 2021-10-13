<?php

namespace App\Models;

use App\Exceptions\InvalidDateException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
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
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_event_recurrent' => 'boolean',
        'happen_at' => 'datetime',
    ];


    /**
     * Set happen at.
     *
     * @throws InvalidDateException
     */
    public function setHappenAtAttribute($value): void
    {
        if($value < now()){
            throw new InvalidDateException('This date is less than the current.');
        }

        $this->attributes['happen_at'] = $value;
    }
}
