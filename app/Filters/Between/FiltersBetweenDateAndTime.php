<?php

namespace App\Filters\Between;

use App\Filters\Between\InvalidNumberOfParams;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;
use App\Traits\DateTime;

class FiltersBetweenDateAndTime implements Filter
{
    use DateTime;

    public function __invoke(Builder $query, $value, string $property): Builder
    {
        if (!(is_array($value) || sizeof($value) >= 2)) {
            throw InvalidNumberOfParams::invalidNumberOfParams();
        }

        $dateTimeFrom = explode(" ", $value[0]);
        $dateTimeTo = explode(" ", $value[1]);
        $nightShift = (sizeof($value) == 3) ? $value[2] : false;

        $from = self::prepareDateTime($value[0], 'AM');
        $to = self::prepareDateTime($value[1], 'PM');

        if(in_array('separate_date_time', $value)) {
            if($from["fullTime"] && $to["fullTime"]) {
                $from = explode(" ", $from["value"]);
                $to = explode(" ", $to["value"]);

                return $query->whereRaw("DATE($property) between '{$from[0]}' AND '{$to[0]}'
                AND TIME($property) BETWEEN '{$from[1]}' AND '{$to[1]}'");
            }

        }

        $from = $from["value"];
        $to = $to["value"];

        return $query->whereRaw("$property BETWEEN '$from' AND '$to'");
    }

    public static function prepareDateTime($dateTime, $defaultTimeFormat = 'AM')
    {
        $dateTimeArray = explode(" ", trim($dateTime));

        // full time is provided
        if(sizeOf($dateTimeArray) == 3) {
            return [
            'fullTime' => true,
            'value' => call_user_func_array(array(DateTime::class, 'dateTimeToStore'), $dateTimeArray)
            ];
        }

        // only two part of date is provided
        if(sizeOf($dateTimeArray) == 2) {
            if(strpos($dateTime, 'AM') || strpos($dateTime, 'PM')) {
                $value = call_user_func_array(array(DateTime::class, 'timeToStore'), $dateTimeArray);
            } else {
                $dateTimeArray = array_merge($dateTimeArray, [$defaultTimeFormat]);
                $value = call_user_func_array(array(DateTime::class, 'dateTimeToStore'), $dateTimeArray);
            }

            return [
            'fullTime' => true,
            'value' => $value,
            ];

        }

        if(strpos($dateTime, '-')) {
            return [
            'fullTime' => false,
            'value' => DateTime::dateToStore($dateTime)
            ];
        }

        if(strpos($dateTime, ':')) {
            return [
            'fullTime' => false,
            'value' => DateTime::timeToStore($dateTime)
            ];
        }
    }
}
