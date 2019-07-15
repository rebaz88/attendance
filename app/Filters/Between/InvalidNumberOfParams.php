<?php

namespace App\Filters\Between;

use Spatie\QueryBuilder\Exceptions\InvalidQuery;
use Illuminate\Http\Response;


class InvalidNumberOfParams extends InvalidQuery
{
    public function __construct()
    {
        $message = "Invalid number of parameters";

        parent::__construct(Response::HTTP_BAD_REQUEST, $message);
    }

    public static function invalidNumberOfParams()
    {
        return new static();
    }
}
