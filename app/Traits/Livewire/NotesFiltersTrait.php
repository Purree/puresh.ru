<?php

namespace App\Traits\Livewire;

use App\Models\Note;
use App\Services\Livewire\NotesFiltersService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

trait NotesFiltersTrait
{
    use AuthorizesRequests;

    protected function rules()
    {
        return [
            'notesOrderFilter' => ['required', "in:" . implode(',', $this->allOrderFilters)],
            'filters' => ['required', 'array:' . implode(',', $this->allOptionalFilters)],
        ];
    }

    protected array $allOrderFilters = ['memberNotes', 'userNotes', 'inIdOrder'];
    protected array $allOptionalFilters = ['showAllUsers', 'showMemberNotes', 'showUserNotes'];
    protected array $filterRelation = ['memberNotes' => 'showMemberNotes', 'userNotes' => 'showUserNotes'];

    public string $notesOrderFilter;
    public array $filters;

    public function changeNoteFilters(array|string $filters = null, string $orderFilter = null)
    {
        if (isset($filters, $orderFilter)) {
            if (is_string($filters)) {
                $this->filters = NotesFiltersService::associateFilters(explode( ',', $filters));
            } else {
                $this->filters = $filters;
            }
            $this->notesOrderFilter = $orderFilter;

            if (array_key_exists($orderFilter, $this->filterRelation)) {
                $this->filters[$this->filterRelation[$orderFilter]] = 'true';
            }
        }

        $this->validateFiltersAndSelectNotes();
    }


    public function validateFiltersAndSelectNotes()
    {
        $this->validate();
        $filtersValidation = NotesFiltersService::validateFilters(
            $this->filters,
            $this->notesOrderFilter,
            $this->filterRelation
        );

        if (!$filtersValidation->success) {
            session()->flash('error', $filtersValidation->errorMessage);
            throw new \Error($filtersValidation->errorMessage);
        }

        $filters = $this->filters;
        $notesOrderFilter = $this->notesOrderFilter;
        $tempFilters = [];
        foreach ($filters as $key => $value) {
            if ($value !== false) {
                $tempFilters[] = $key;
            }
        }
        $this->filtersString = implode(',', $tempFilters);
        unset($tempFilters);

        $this->orderFilter = $notesOrderFilter;

        $this->selectNotesByFilters($filters, $notesOrderFilter);
    }


    public function selectNotesByFilters($filters, $notesOrderFilter)
    {
        $notes = Note::with('user', 'images');

        if (!array_key_exists('showAllUsers', $filters) || $filters['showAllUsers'] === false) {
            if (isset($filters['showUserNotes']) && $filters['showUserNotes']) {
                $notes = $notes->where('notes.user_id', Auth::id());
            }

            if (isset($filters['showMemberNotes']) && $filters['showMemberNotes']) {
                $notes = $notes->orWhereRelation('user', 'note_user.user_id', '=', Auth::id());
            }
        }

        // Firstly return notes where owner is Auth user, after return all another
        if ($notesOrderFilter === 'userNotes') {
            $notes = $notes->orderBy(DB::raw('ABS(notes.user_id-' . Auth::id() . ')'));
        }

        // Firstly return notes where collaborator is Auth user, after return all another
        if ($notesOrderFilter === 'memberNotes') {
            $noteIds = [];
            foreach ($notes->get()->reverse() as $note) {
                if (in_array(Auth::id(), $note->user->pluck('id')->toArray(), true)) {
                    array_unshift($noteIds, $note->id);
                } else {
                    $noteIds[] = $note->id;
                }
            }

            $notes = ($notes->orderByRaw('FIELD(id, ' . implode(', ', $noteIds) . ')'));
            // DEPRECATED:
//            $notes = $notes->join('note_user', 'notes.id', '=', 'note_user.note_id')
//                ->orderBy(DB::raw('ABS(note_user.user_id-' . Auth::id() . ')'));
        }

        $this->notes = $notes->paginate(10);
        $this->filtered = true;
    }

    public function clearFilters()
    {
        $this->filters = [];
        $this->filtersString = '';
        $this->notesOrderFilter = '';
        $this->orderFilter = '';
        $this->filtered = false;
        $this->emitSelf('refreshNotes');
    }
} // TODO: REFACTOR!!
