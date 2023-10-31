<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class ClientFilterRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'nome_fantasia' => ['nullable', 'string'],
            'cnpj' => ['nullable', 'string'],
            'telefone' => ['nullable', 'string'],
        ];
    }

    protected function prepareForValidation()
    {
        return $this->merge([
            'cnpj' => preg_replace('/\D/', '', $this->cnpj),
            'telefone' => preg_replace('/\D/', '', $this->telefone),
        ]);
    }
}
