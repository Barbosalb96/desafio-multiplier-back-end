<?php

namespace App\Http\Requests\Commom;

use Illuminate\Foundation\Http\FormRequest;

class AuthLoginRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            "email" => ['required', 'email'],
            "password" => ['required', 'min:2'],
        ];
    }
}
