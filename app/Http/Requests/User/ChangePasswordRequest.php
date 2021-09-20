<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'oldpassword'=>'required|min:8|max:255|string',
            'password'=>'required|min:8|max:255|string|confirmed'
        ];
    }
}
