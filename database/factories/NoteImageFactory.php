<?php

namespace Database\Factories;

use App\Models\Note;
use App\Models\NoteImage;
use Illuminate\Database\Eloquent\Factories\Factory;

class NoteImageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = NoteImage::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'note_id' => Note::inRandomOrder()->first(),
            'note_image_path' => 'https://source.unsplash.com/random',
        ];
    }
}
