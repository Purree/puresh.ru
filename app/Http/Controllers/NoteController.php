<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Contracts\View\View;

class NoteController extends Controller
{
    public function showNotes(): View
    {

        $notes = Note::paginate(10);

        return view('notes.notes', [
            'notes' => $notes
        ]);
    }
}
