<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SchoolCreateRequest extends FormRequest
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
            'school_name'=> 'required',
            'address'=>  'required',
            'phone_no1'=>  'required|numeric',
            'phone_no1'=>  'numeric',
            'established_at' => 'required|date',
            'school_owner'=>  'required',
            "email" => "required|email:rfc,dns|max:128|unique:users,email,".$this->user_id.",id",
        ];
    }


    public function messages(){
        return[
            'school_name.required' => 'School Name is required',
            'address.required' => 'Address field is required',
            'phone_no1.required' => 'Phone_no1 fieldis required',
            'phone_no1.numeric' => 'Phone_no1 should be numbers',
            'phone_no2.numeric' => 'Phone_no2 should be numbers',
            'established_at.required' => 'Year of estalishment field is required',
            'school_owner.required' => 'School Owner field is required',
            'email.required'=> 'Email  is field required',
            'email.unique'=> 'Email  Already Exist',
        ];
    }
}
