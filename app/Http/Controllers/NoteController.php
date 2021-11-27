<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Permission;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class NoteController extends Controller
{
    public function showNotes(): View
    {

        $notes = [];

        if(Gate::allows('manage_data', Permission::class)){
            $notes = Note::with('user', 'images')->paginate(10);
        } else {
            $notes = Note::with('user', 'images')
                ->where('user_id', Auth::id())
                ->orWhereRelation('user', 'user_id', '=', Auth::id())
                ->paginate(10);
        }

        return view('notes.notes', [
            'notes' => $notes
        ]);
    }
}
