<?php

namespace App\Http\Requests\Users;

use App\Http\Requests\BaseFormRequest;

class StoreUser extends BaseFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [

            'name' => 'bail|required|max:255|unique:users',

            'email' => 'bail|required|email|unique:users',

            'role' => 'bail|required',

            // 'agent' => 'bail|required_if:role,==,Agent',

        ];
    }
}
