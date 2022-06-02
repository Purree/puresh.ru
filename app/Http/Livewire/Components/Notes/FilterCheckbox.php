<?php

namespace App\Http\Livewire\Components\Notes;

use Livewire\Component;

class FilterCheckbox extends Component
{
    public string $filterValue;
    public string $filterName;
    public string $filterText;
    public array $filters;

    public function render()
    {
        return view('livewire.components.notes.filter-checkbox');
    }
}
