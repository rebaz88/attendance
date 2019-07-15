<?php

namespace App\Filters\Between;

use App\Filters\Between\InvalidNumberOfParams;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;
use App\Traits\DateTime;

class FiltersBetweenTime implements Filter
{
    use DateTime;

    public function __invoke(Builder $query, $value, string $property): Builder
    {
        if (!is_array($value) || sizeof($value) != 2) {
            throw InvalidNumberOfParams::invalidNumberOfParams();
        }

        $value[0] = DateTime::timeToStore($value[0]);
        $value[1] = DateTime::timeToStore($value[1]);

        return $query->whereRaw("TIME($property) BETWEEN '{$value[0]}' AND '{$value[1]}'");
    }
}
