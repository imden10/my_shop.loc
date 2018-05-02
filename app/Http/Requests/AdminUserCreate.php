<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AdminUserCreate extends Request
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
            'name'                  => 'required',
            'email'                 => 'email|required|unique:users',
            'password'              => 'required|min:4|confirmed'
        ];
    }

    public function messages()
    {
        return [
            'email.email'                   => 'E-mail - не коректен',
            'email.required'                => 'E-mail - обизательное поле для заполнения',
            'email.unique'                  => 'Пользователь с таким e-mail уже существует',
            'password.required'             => 'Пароль - обизательное поле для заполнения',
            'password.min'                  => 'Пароль должен содержать минимум 4 символа',
            'password.confirmed'            => 'Пароли не совпадают',
            'name.required'                 => 'Имя - обизательное поле для заполнения'
        ];
    }
}
