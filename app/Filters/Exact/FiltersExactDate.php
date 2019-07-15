<?php

namespace App\Filters\Exact;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;
use App\Traits\Datetime;

class FiltersExactDate implements Filter
{
    use DateTime;

    public function __invoke(Builder $query, $value, string $property): Builder
    {
        if (is_array($value)) {
            $value = collect($value)->map(function($value) {
                return DateTime::dateToDisplay($value);
            })->toArray();
            return $query->whereIn($property, $value);
        }

        return $query->where($property, DateTime::dateToStore($value));
    }
}
