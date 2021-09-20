<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email'   =>'required|email',
            'password'=>'required|min:8|max:255|string|confirmed',
            'token'   =>'required|string'
        ];
    }
}
