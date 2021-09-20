<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class FeatureRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'tag'  => 'required|min:5|max:255|alpha_dash',
            'label'=> 'required|min:5|max:255',
            'cost' => 'required|min:0|max:255'
        ];
    }
}
