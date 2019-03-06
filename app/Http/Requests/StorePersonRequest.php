<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StorePersonRequest extends Request {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return TRUE;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'name' => 'required',
            'EGN' => 'required|digits:10|numeric',
            'email' => 'required|email'
        ];
    }

    public function messages() {
        return [
            'required' => ':attribute e задължително поле',
            'digits' => ':attribute трябва да бъде  :digits символа',
            'numeric' => ':attribute трябва да съдържа само числа',
            'email' => 'невалиден емайл',
        ];
    }

}
