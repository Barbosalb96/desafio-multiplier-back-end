<?php

namespace App\Http\Requests\V1;

use App\Domain\Client\Entities\Client;
use App\Rules\ValidaCnpj;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClientStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "cnpj" => ['required', new ValidaCnpj, 'max:14', Rule::unique(Client::class, 'cnpj')],
            "nome_fantasia" => ['required', 'string', 'min:4'],
            "email" => ['required', 'email', 'min:11', Rule::unique(Client::class, 'email')],
            "endereco" => ['required', 'string'],
            "cidade" => ['required', 'string'],
            "estado" => ['required', 'string'],
            "pais" => ['required', 'string'],
            "telefone" => ['required', 'integer', 'min:11'],
            "area_atuacao_cnae" => ['required', 'string'],
            "qsa" => ['nullable', 'array'],
            "qsa.*.nome" => ['nullable', 'string'],
            "qsa.*.qualificacao" => ['nullable', 'string'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'cnpj' => preg_replace('/\D/', '', $this->cnpj),
            'telefone' => preg_replace('/\D/', '', $this->telefone),
        ]);
    }
}
