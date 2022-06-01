<?php

namespace App\Http\Filters;

use App\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NoteFilter extends QueryFilter
{
    public function filtersString(string $drawFilters): void
    {
        $filters = explode(",", $drawFilters);

        if (array_key_exists('showAllUsers', $filters) && !\Gate::allows('manage_data', Permission::class)) {
            unset($filters['showAllUsers']);
        }

        if (!array_key_exists('showAllUsers', $filters)) {
            if (isset($filters['showUserNotes']) && $filters['showUserNotes']) {
                $this->builder->where('notes.user_id', Auth::id());
            }

            if (isset($filters['showMemberNotes']) && $filters['showMemberNotes']) {
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
