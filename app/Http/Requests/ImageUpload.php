<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImageUpload extends FormRequest
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
          'school_logo' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048|dimensions:max_width=100,max_height=100',
    ];
    }


    public function messages(){
        return[
         'school_logo.required' =>'Image not found',
            'school_logo.image' =>'file must be an image',
            'school_logo.mimes' =>'Image must be jpg, png, jpeg, gif,svg',
            'school_logo.dimensions' =>'max width must be 100, max height must be 100'
        ];
    }
}
