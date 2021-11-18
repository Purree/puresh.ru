<?php

namespace Database\Factories;

use App\Models\Note;
use App\Models\NoteCollaborators;
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
            'user_id' => User::getRandom(),
            'text' => $this->faker->text,
            'title' => $this->faker->name,
            'is_completed' => $this->faker->boolean,
            'created_at' => $this->faker->dateTimeBetween('-2 years', '-1 year'),
            'completed_at' => $this->randomizeCompletedAt(),
        ];
    }


    /**
     * Indicate that the note should have a collaborators.
     *
     * @return $this
     * @throws Exception
     */
    public function withCollaborators(int $collaboratorsCount = 3): static
    {
        return $this->has(
            NoteCollaborators::factory()->count($collaboratorsCount)
                ->state(function (array $attributes, Note $note) {
                    echo random_int(0, 3);
                    return ['user_id' => User::getRandom(), 'note_id' => $note->id];
                }),
            'collaborators'
        );
    }
}
