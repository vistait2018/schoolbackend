<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'name' => 'required',
            "email" => "required|email|max:128|unique:users,email,".$this->user_id.",id",
            'password' => 'required|confirmed|min:6'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name field is required',
            'email.required' => 'Email field is required',
            'email.email' => 'Email must be valid email',
            'password.required' =>'Password is required,',
            'password.confirmed'=> 'Password does not match confirmation Password'
        ];
    }
}
