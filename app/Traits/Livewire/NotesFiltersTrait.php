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
        $this->setFilters($filters, $orderFilter);

        $validatedFilters = $this->validateFilters();

        $filteredNotes = $this->selectNotesByFilters(...$validatedFilters);

        $this->notes = $filteredNotes->paginate(10);
        $this->filtered = true;
    }

    public function setFilters(array|string $filters = null, string $orderFilter = null)
    {
        if (isset($filters, $orderFilter)) {
            if (is_string($filters)) {
                $this->filters = NotesFiltersService::associateFilters(explode(',', $filters));
            } else {
                $this->filters = $filters;
            }
            $this->notesOrderFilter = $orderFilter;

            if (array_key_exists($orderFilter, $this->filterRelation)) {
                $this->filters[$this->filterRelation[$orderFilter]] = 'true';
            }
        }
    }


    public function validateFilters()
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

        $filtersCached = $this->filters;
        $orderFilterCached = $this->notesOrderFilter;
        $tempFilters = [];
        foreach ($filtersCached as $key => $value) {
            if ($value !== false) {
                $tempFilters[] = $key;
            }
        }
        $this->filtersString = implode(',', $tempFilters);
        unset($tempFilters);

        $this->orderFilter = $orderFilterCached;

        return [$filtersCached, $orderFilterCached];
    }

    public function getFilteredNotes($filters)
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

        return $notes;
    }

    public function orderNotes($notes, $notesOrderFilter)
    {
        // Firstly return notes where owner is Auth user, after return all another
        if ($notesOrderFilter === 'userNotes') {
            $notes = $notes->orderBy(DB::raw('ABS(notes.user_id-'.Auth::id().')'));
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

            $notes = ($notes->orderByRaw('FIELD(id, '.implode(', ', $noteIds).')'));
        }

        return $notes;
    }

    public function selectNotesByFilters($filters, $notesOrderFilter)
    {
        $notes = $this->getFilteredNotes($filters);

        return $this->orderNotes($notes, $notesOrderFilter);
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
}
