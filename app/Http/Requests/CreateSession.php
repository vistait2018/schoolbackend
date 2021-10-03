<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateSession extends FormRequest
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
            'start' => 'required|digits:4|min:'.(date('Y')).'|max:'.(date('Y')),
            'end' => 'required|digits:4|min:'.(date('Y') +1).'|max:'.(date('Y')+1),

        ];
    }

    public function messages(){
        return[
            'start.required' => 'Start year Required',
            'end.required' => 'End year field is required',
            'start.digits' =>'Start field must be a number',
            'end.digits' =>'End field must be a number',
            'start.min' =>'Minimum start year is this year',
            'start.max' =>'Maximum start year is this year',
            'end.max' =>'Maximum end year is this year + 1',
            'end.min' =>'Minimum end year is this year + 1',
        ];
    }
}
