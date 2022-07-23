<?php

namespace App\Http\Filters;

use App\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\UnauthorizedException;

class NoteFilter extends QueryFilter
{
    public function filters(array $filters): void
    {
        if (in_array('showAllUsers', $filters, true) && ! \Gate::allows('manage_data', Permission::class)) {
            throw new UnauthorizedException(__('You do not have the required access rights'));
        }

        if (! in_array('showAllUsers', $filters, true)) {
            if (in_array('showUserNotes', $filters, true)) {
                $this->builder->where('notes.user_id', Auth::id());
            }

            if (in_array('showMemberNotes', $filters, true)) {
                $this->builder->orWhereRelation('user', 'note_user.user_id', '=', Auth::id());
            }
        }
    }

    public function orderFilter(string $filter): void
    {
        // Firstly return notes where owner is Auth user, after return all another
        if ($filter === 'userNotes') {
            $this->builder->orderByDesc(DB::raw('FIELD(notes.user_id, '.Auth::id().')'));
        }

        // Firstly return notes where collaborator is Auth user, after return all another
        if ($filter === 'memberNotes') {
            $noteIds = [];
            foreach ($this->builder->get()->reverse() as $note) {
                if (in_array(Auth::id(), $note->user->pluck('id')->toArray(), true)) {
                    array_unshift($noteIds, $note->id);
                } else {
                    $noteIds[] = $note->id;
                }
            }

            $this->builder->orderByRaw('FIELD(id, '.implode(', ', $noteIds).')');
        }
    }
}
