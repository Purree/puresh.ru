<?php

namespace Database\Factories;

use App\Models\Note;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;

class NoteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Note::class;


    /**
     * Return random date between -1 year and now or null.
     *
     * @throws Exception
     */
    public function randomizeCompletedAt(): ?\DateTime
    {
        return random_int(0, 1) ? $this->faker->dateTimeBetween('-1 year', now()) : null;
    }

    /**
     * Define the model's default state.
     *
     * @return array
     * @throws Exception
     */
    #[ArrayShape([
        'user_id' => "mixed",
        'text' => "string",
        'title' => "string",
        'is_completed' => "bool",
        'created_at' => \DateTime::class,
        'completed_at' => \DateTime::class
    ])] public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first(),
            'text' => $this->faker->text,
            'title' => $this->faker->name,
            'is_completed' => $this->faker->boolean,
            'created_at' => $this->faker->dateTimeBetween('-2 years', '-1 year'),
            'completed_at' => $this->randomizeCompletedAt(),
        ];
    }
}
