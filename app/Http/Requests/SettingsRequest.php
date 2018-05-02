<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class SettingsRequest extends Request
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
            'logo1' => 'mimes:jpeg,bmp,png,jpg',
            'logo2' => 'mimes:jpeg,bmp,png,jpg',
            'slogan' => 'required',
            'email' => 'required',
            'rights' => 'required',
            'phone' => 'required',
        ];
    }
}