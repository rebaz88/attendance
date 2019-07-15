<?php

namespace App\Filters;

use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class FiltersExclude implements Filter
{
    public function __invoke(Builder $query, $value, string $property): Builder
    {
        return $query;
    }
}
