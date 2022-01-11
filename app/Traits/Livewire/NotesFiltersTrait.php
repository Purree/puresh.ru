<?php

namespace App\Traits\Livewire;

use App\Services\Livewire\NotesFiltersService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

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

    public function changeNoteFilters($filters = null, $orderFilter = null)
    {
        if ($filters && $orderFilter) {
            $this->filters = NotesFiltersService::associateFilters(explode( ',', $filters));
            $this->notesOrderFilter = $orderFilter;
        }

        $this->validate();
        $isFiltersValidatedSuccessful = NotesFiltersService::validateFilters($this->filters, $this->notesOrderFilter, $this->filterRelation);
        if(!$isFiltersValidatedSuccessful){
            return false;
        }

        $this->emit('changeFilters', [$this->filters, $this->notesOrderFilter]);
    }
}
