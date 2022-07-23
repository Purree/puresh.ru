<?php

namespace App\Http\Livewire\Components\Notes;

use Livewire\Component;

class FilterRadio extends Component
{
    public string $filterValue;

    public string $filterName;

    public string $filterText;

    public string $filterOrder;

    public function render()
    {
        return view('livewire.components.notes.filter-radio');
    }
}
