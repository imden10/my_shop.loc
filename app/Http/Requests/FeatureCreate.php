<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class FeatureCreate extends Request
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
            'name'      => 'required|unique:features_loc'
        ];
    }

    public function messages()
    {
        return [
            'name.required'       => 'Название - обизательное поле для заполнения',
            'name.unique'         => 'Название - долно быть уникальным',
        ];
    }
}
