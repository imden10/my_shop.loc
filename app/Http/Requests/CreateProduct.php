<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateProduct extends Request
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
            'name'          => 'required',
            'slug'          => 'required|unique:products',
            'categories'    => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required'         => 'Название - обизательное поле для заполнения',
            'slug.required'         => 'URL - обизательное поле для заполнения',
            'slug.unique'           => 'URL - должен быть уникальный',
            'categories.required'   => 'Категория - обизательное поле для заполнения',
        ];
    }
}
