<?php

namespace App\Filters\Exact;

use App\Filters\Exact\FiltersExact;
use App\Filters\Exact\FiltersExactDate;
use App\Filters\Exact\FiltersExactTime;
use App\Filters\Exact\FiltersExactDateAndTime;
use Spatie\QueryBuilder\Filter;

class FiltersExactFacade
{
    public static function getExactFilter($field, $fieldType)
    {
        if (!isset($fieldType)) {
            return Filter::custom($field, FiltersExact::class);
        }

        switch (strtolower($fieldType)) {

            case ('date'):
                return Filter::custom($field,
                FiltersExactDate::class);
                break;

            case ('time'):
                return Filter::custom($field,
                FiltersExactTime::class);
                break;

            case ('datetime'):
                return Filter::custom($field,
                FiltersExactDateAndTime::class);
                break;

            default:
                return Filter::custom($field,
                FiltersExact::class);
                break;
    }
}
}
