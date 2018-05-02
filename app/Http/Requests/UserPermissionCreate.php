<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UserPermissionCreate extends Request
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
            'name'              => 'required',
            'display_name'      => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required'              => 'Название - обизательное поля для заполнения',
            'display_name.required'      => 'Имя для отображения - обизательное поля для заполнения',
        ];
    }
}
