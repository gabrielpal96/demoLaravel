<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StoreAuthRequest extends Request {

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
            'username' => 'required',
            'password' => 'required|min:4',
            'g-recaptcha-response' => 'required|recaptcha',
        ];
    }

}
