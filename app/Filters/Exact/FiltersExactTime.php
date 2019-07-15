<?php

namespace App\Filters\Exact;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;
use App\Traits\Datetime;

class FiltersExactTime implements Filter
{
    use DateTime;
    public function __invoke(Builder $query, $value, string $property): Builder
    {
        if (is_array($value)) {
            $value = collect($value)->map(function($value) {
                return DateTime::timeToDisplay($value);
            })->toArray();
            return $query->whereIn($property, $value);
        }

        return $query->where($property, DateTime::timeToStore($value));
    }
}
