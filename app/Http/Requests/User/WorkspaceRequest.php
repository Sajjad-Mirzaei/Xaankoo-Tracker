<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class WorkspaceRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'label'      =>'required|min:5|max:255',
            'url'        =>'required|min:5|max:255|string',
            'description'=>'required|min:5|max:255|string'
        ];
    }
}
