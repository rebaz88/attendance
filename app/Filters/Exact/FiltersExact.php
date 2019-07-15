<?php

namespace App\Filters\Exact;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;


class FiltersExact implements Filter
{
    public function __invoke(Builder $query, $value, string $property): Builder
    {
        if (is_array($value)) {
            return $query->whereIn($property, $value);
        }

        return $query->where($property, $value);
    }
}
