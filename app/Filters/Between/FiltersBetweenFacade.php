<?php

namespace App\Filters\Between;

use Spatie\QueryBuilder\Filter;
use App\Filters\Between\FiltersBetween;
use App\Filters\Between\FiltersBetweenDate;
use App\Filters\Between\FiltersBetweenTime;
use App\Filters\Between\FiltersBetweenDateAndTime;

class FiltersBetweenFacade
{
    public static function getBetweenFilter($field, $fieldType)
    {
        if (!isset($fieldType)) {
            return Filter::custom($field, FiltersBetweenDate::class);
        }

        switch (strtolower($fieldType)) {
            case ('date'):
                return Filter::custom($field,
                    FiltersBetweenDate::class);
                break;

            case ('time'):
                return Filter::custom($field,
                    FiltersBetweenTime::class);
                break;

            case ('date_time'):
                return Filter::custom($field,
                    FiltersBetweenDateAndTime::class);
                break;

            default:
                return Filter::custom($field,
                    FiltersBetween::class);
                break;
        }
    }
}
