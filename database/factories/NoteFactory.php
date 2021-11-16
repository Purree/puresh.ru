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
     * @throws Exception
     */
    private function getRandomUser()
    {
        return User::find(random_int(1, User::count()));
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
        'is_completed' => "bool",
        'created_at' => \DateTime::class,
        'completed_at' => \DateTime::class
    ])] public function definition(): array
    {
        return [
            'user_id' => $this->getRandomUser(),
            'text' => $this->faker->text,
            'is_completed' => $this->faker->boolean,
            'created_at' => $this->faker->dateTimeBetween('-2 years', '-1 year'),
            'completed_at' => $this->faker->dateTimeBetween('-1 year', now()),
        ];
    }
}
