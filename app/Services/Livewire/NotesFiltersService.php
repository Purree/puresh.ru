<?php

namespace App\Services\Livewire;

use App\Models\Permission;
use App\Services\Results\FunctionResult;

class NotesFiltersService
{
    public static function associateFilters(array $filters): array
    {
        return array_map(static fn($v) => 'true', array_flip($filters));
    }

    public static function validateFilters(&$filters, $notesOrderFilter, $filterRelation): FunctionResult
    {
        if (array_key_exists('showAllUsers', $filters) && !\Gate::allows('manage_data', Permission::class)) {
            unset($filters['showAllUsers']);
        }

        if (!array_filter($filters)) {
            return FunctionResult::error(__('You have not selected any filters'));
        }

        foreach ($filterRelation as $key => $value) {
            if ($key === $notesOrderFilter && in_array($value, $filters, true)) {
                unset($filters[$value]);
            }
        }

        return FunctionResult::success();
    }
}
