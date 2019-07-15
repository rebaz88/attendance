<?php

namespace App\Filters\Between;

use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use App\Filters\Between\InvalidNumberOfParams;

class FiltersBetween implements Filter
{
    public function __invoke(Builder $query, $value, string $property): Builder
    {
        if (!is_array($value) || sizeof($value) != 2) {
            throw InvalidNumberOfParams::invalidNumberOfParams();
        }

        return $query->whereBetween($property, $value);
    }
}
