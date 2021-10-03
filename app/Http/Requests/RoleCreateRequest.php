<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class RoleCreateRequest extends FormRequest
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
            'name'=>'required|unique:roles,name',
            'slug' => 'required|unique:roles,slug'
        ];
    }


    public function messages(){
        return[
           'name.required' =>'Role Name is Required',
           'name.unique'  =>'Role Name Already exists.',
            'slug.required' =>'Slug is Required',
            'slug.unique'  =>'Slug Already exists.',
        ];
    }
}
