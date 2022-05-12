<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MedicienStoreRequest extends FormRequest
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
            'name' =>  ['required', 'string', 'max:255'],
            'type' =>  ['required', 'string', 'max:255'],
            'disc' =>  ['required', 'max:255'],
            'avilablesunit' =>  ['required', 'max:255'],
            'smallprice' =>  ['required', 'max:255'],
            'packet' =>  ['required', 'integer', 'max:255'],
            'min' =>  ['required', 'max:255'],
            'place_name' =>  ['required', 'string', 'max:255'],
            'category_name' =>  ['required', 'string', 'max:255'],
        ];
    }
}
