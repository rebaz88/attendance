<?php

namespace App\Http\Requests\Roles;

use App\Http\Requests\BaseFormRequest;

class UpdateRole extends BaseFormRequest
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
          'name' => 'required|max:255|unique:roles,name,'. $this->get('id')
      ];
  }
}
