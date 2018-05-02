<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class LanguagesCreate extends Request
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
            'name' => 'required',
            'lang' => 'required|min:2|unique:languages',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Название - обизательное поле для заполнения',
            'lang.required' => 'Код - обизательное поле для заполнения',
            'lang.min'      => 'Код - минимум 2 символа',
            'lang.unique'   => 'Код - должен быть уникальным',
        ];
    }
}
