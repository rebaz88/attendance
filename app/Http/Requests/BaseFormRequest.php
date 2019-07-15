<?php

namespace App\Http\Requests;

use Illuminate\Http\JsonResponse;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;

class BaseFormRequest extends FormRequest
{

    /**
    * Handle a failed validation attempt.
    *
    * @param  \Illuminate\Contracts\Validation\Validator  $validator
    * @return void
    *
    * @throws \Illuminate\Validation\ValidationException
    */
    protected function failedValidation(Validator $validator)
    {

        $error = ezReturnErrorMessage($validator->messages()->first());
        $response = new JsonResponse($error, 422);

        throw (new ValidationException($validator, $response))
        ->errorBag($this->errorBag)
        ->redirectTo($this->getRedirectUrl());
    }

    public function canProceed($permissions = [], $roles = [])
    {
      return $this->user()->hasAnyPermission($permissions);
    }

    public function removeCommaFromNumbers(string $fields)
    {
        $fields = explode(',', $fields);

        foreach ($fields as $field) {
            if($this->has($field)) {
                $value = str_replace(',', '', trim($this->{$field}));
                $this->merge(["$field" => $value]);
            }
        }
    }

}
