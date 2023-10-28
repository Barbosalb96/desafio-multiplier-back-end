<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;

class ValidaCnpj implements ValidationRule
{

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $response = Http::get("https://brasilapi.com.br/api/cnpj/v1/{$value}");

        $statusCode = $response->status() === 200;

        if (!$statusCode) {
            $fail('O CNPJ não é válido.');
        }

    }
}
