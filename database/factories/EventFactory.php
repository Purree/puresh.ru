<?php

namespace Database\Factories;

use App\Models\Event;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Event::class;

    /**
     * Define the model's default state.
     *
     * @return array
     *
     * @throws Exception
     */
    public function definition()
    {
        return [
            'title' => $this->faker->words(3, true),
            'happen_at' => $this->faker->dateTimeBetween(now(), '+1 year'),
            'is_event_recurrent' => $this->faker->boolean,
        ];
    }
}
