<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Routing\Redirector;

class RegisterRequest extends FormRequest
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
            'first_name'=>'required|alpha|bail',
            'last_name'=>'required|alpha|bail',
            'email'=>'required|email|unique:users|bail',
            'password'=>'required|min:6|confirmed|bail',
            'subject'=>'required|bail',
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        return response()->json([
            'errors' => $validator->errors(),
        ],400);
    }
}
