<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UpdateProduct extends Request
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
            'slug'          => 'required',
            'categories'    => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required'         => 'Название - обизательное поле для заполнения',
            'slug.required'         => 'URL - обизательное поле для заполнения',
            'categories.required'   => 'Категория - обизательное поле для заполнения',
        ];
    }
}
