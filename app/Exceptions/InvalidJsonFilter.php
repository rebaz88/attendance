<?php

namespace App\Exceptions;

use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Symfony\Component\HttpKernel\Exception\HttpException;

class InvalidJsonFilter extends HttpException
{

    public function __construct(String $jsonString)
    {
        $message = "Invalid json filter string `{$jsonString}` is provided";

        parent::__construct(Response::HTTP_BAD_REQUEST, $message);
    }

    public static function invalidJsonString(String $jsonString)
    {
        return new static(...func_get_args());
    }
}
