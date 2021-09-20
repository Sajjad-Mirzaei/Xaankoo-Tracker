<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email'   =>'required|min:5|max:255|email',
            'password'=>'required|min:8|max:255|string'
        ];
    }
}
