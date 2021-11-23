<?php

namespace Database\Seeders;

use App\Models\Note;
use App\Models\NoteImage;
use App\Models\User;
use Exception;
use Illuminate\Database\Seeder;

class NoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run(): void
    {
        Note::factory()
            ->count(300)
            ->create();

        // Add from 0 to 3 random users to each note
        foreach (Note::all() as $note) {
            $users = User::inRandomOrder()->take(random_int(0, 3))->pluck('id');
            $note->user()->attach($users);
        }

        NoteImage::factory()
            ->count(300)->create();
    }
}
