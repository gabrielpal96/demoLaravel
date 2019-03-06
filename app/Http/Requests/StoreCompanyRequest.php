<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StoreCompanyRequest extends Request {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

//    public function wantsJson() {
//        return true;
//    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'name' => 'required',
            'bulstat' => 'required|digits:10|numeric',
            'address' => 'required'
        ];
    }

    public function messages() {
        return [
            'required' => ':attribute e задължително поле',
            'max' => ':attribute e надвишава :max символа',
            'min' => ':attribute e по малко от  :min символа',
            'digits' => ':attribute трябва да бъде  :digits символа',
            'numeric' => ':attribute трябва да съдържа само числа',
        ];
    }

}
