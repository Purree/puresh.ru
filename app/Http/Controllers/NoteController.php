<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\User;
use Illuminate\Contracts\View\View;

class NoteController extends Controller
{
    public function showNotes(): View
    {

        $notes = Note::with('user')->paginate(10);

        return view('notes.notes', [
            'notes' => $notes,
            'users' => User::all()
        ]);
    }
}
