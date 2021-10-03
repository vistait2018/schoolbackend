<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRoleGetRequest extends FormRequest
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
            'roles' => 'required|array:roles,locale'
        ];
    }

    public function messages(){
        return [
            'roles.required' =>'Roles are required',
            'roles.array' =>'Roles are must be a array',
        ];
    }
}
