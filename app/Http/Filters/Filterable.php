<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

trait Filterable
{
    public function scopeFilter(Builder $builder, QueryFilter $filter): void
    {
        $filter->apply($builder);
    }
}
