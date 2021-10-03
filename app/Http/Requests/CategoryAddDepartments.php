<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryAddDepartments extends FormRequest
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
            'department_ids'=> 'required|array'
        ];
    }

    public function messages(){
        return [
            'department_ids.required'=> 'Department_ids are required',
            'department_ids.array'=> 'Department_ids must be an array',
        ];
    }
}
