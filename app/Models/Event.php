<?php

namespace App\Models;

use App\Exceptions\InvalidDateException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use JetBrains\PhpStorm\ArrayShape;
use Illuminate\Database\Eloquent\Collection;

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
        if ($value < now()) {
            throw new InvalidDateException('This date is less than the current.');
        }

        $this->attributes['happen_at'] = $value;
    }

    /**
     * Check if all dates are greater than today
     */
    public static function validateAllDates(): void
    {
        $expiredEvents = self::getExpiredEvents();

        if($expiredEvents['expiredRecurrentEvents']) {
            self::updateDates('validate data', $expiredEvents['expiredRecurrentEvents']);
        }

        if($expiredEvents['expiredNonRecurrentEvents']) {
            self::deleteEvents($expiredEvents['expiredNonRecurrentEvents']);
        }
    }


    /**
     * Update dates according to $actionsOverTime
     *
     * @param string $actionsOverTime
     * @param Collection $dates
     */
    public static function updateDates(string $actionsOverTime, Collection $dates): void
    {
        foreach ($dates as $date) {
            $validatedDate = null;
            if($actionsOverTime === 'validate data') {
                $validatedDate = self::validateData($date);
            }

            $date->happen_at = $validatedDate;

            $date->save();
        }
    }

    public static function validateData($date): string
    {
        if($date->repetition_in_seconds){
            $differenceBetweenDates = now()->timestamp - $date->happen_at->timestamp;
            $differenceBetweenDates = floor($differenceBetweenDates/$date->repetition_in_seconds) + 1;
            return date('Y-m-d H:i:s', $date->happen_at->timestamp +
                $date->repetition_in_seconds * $differenceBetweenDates);
        }

        $validatedYear = date('Y');

        if(date('Y-m-d H:i:s', strtotime($date->happen_at . $validatedYear)) < now()){
            ++$validatedYear;
        }

        return date('Y-m-d H:i:s',
            strtotime($date->happen_at .
                $validatedYear));
    }

    /**
     * Delete events from db
     *
     * @param Collection|array $events
     */
    public static function deleteEvents(Collection | array $events): void
    {
        foreach ($events as $event) {
            $event->delete();
        }
    }

    /**
     * Return expired events
     *
     * @return array
     */
    #[ArrayShape(['expiredNonRecurrentEvents' => "mixed", 'expiredRecurrentEvents' => "mixed"])] public static function getExpiredEvents(): array
    {
        $expiredRecurrentDates = self::where('happen_at', '<', now())
            ->where('is_event_recurrent', true)
            ->get();

        $expiredDates = self::where('happen_at', '<', now())
            ->where('is_event_recurrent', false)
            ->get();

        return [
            'expiredNonRecurrentEvents' => $expiredDates->count() > 0 ? $expiredDates : false,
            'expiredRecurrentEvents' => $expiredRecurrentDates->count() > 0 ? $expiredRecurrentDates : false
        ];
    }
}

// TODO: Сделать, чтобы можно было рефакторить валидировать только часть дат
// TODO: Добавить добавление нового таймера в админку
