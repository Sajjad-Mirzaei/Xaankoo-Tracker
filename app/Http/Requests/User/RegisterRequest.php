<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'    =>'required|min:5|max:255|string',
            'username'=>'required|min:5|max:255|alpha_dash|unique:users',
            'email'   =>'required|min:5|max:255|email|unique:users',
            'password'=>'required|min:8|max:255|string|confirmed'
        ];
    }
}
