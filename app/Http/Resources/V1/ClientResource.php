<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id_public" => $this->id_public,
            "nome_fantasia" => $this->nome_fantasia,
            "email" => $this->email,
            "cnpj" => $this->cnpj,
            "endereco" => $this->endereco,
            "cidade" => $this->cidade,
            "estado" => $this->estado,
            "pais" => $this->pais,
            "telefone" => $this->telefone,
            "area_atuacao_cnae" => $this->area_atuacao_cnae,
            "qsas" => $this->qsas->map(function ($qsa) {
                return [
                    "nome" => $qsa->nome,
                    "qualificacao" => $qsa->qualificacao,
                ];
            }),
        ];
    }
}
