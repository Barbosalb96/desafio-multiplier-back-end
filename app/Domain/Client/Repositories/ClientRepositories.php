<?php

namespace App\Domain\Client\Repositories;

use App\Domain\Client\Entities\Client;
use App\Domain\Client\Entities\Qsa;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class ClientRepositories
{
    public function __construct(
        private readonly Client $client,
        private readonly Qsa    $qsa,
    )
    {

    }

    public function all(array $filterParams)
    {
        $name = Arr::get($filterParams, 'nome_fantasia');
        $cnpj = Arr::get($filterParams, 'cnpj');
        $telefone = Arr::get($filterParams, 'telefone');
        $cacheKey = 'clients_' . md5(serialize($filterParams));

        return Cache::rememberForever($cacheKey, function () use ($name, $cnpj, $telefone) {
            return $this->client->query()
                ->with('qsas')
                ->when(!empty($name), fn($query) => $query->where('nome_fantasia', 'like', "%{$name}%"))
                ->when(!empty($cnpj), fn($query) => $query->where('cnpj', 'like', "%{$cnpj}%"))
                ->when(!empty($telefone), fn($query) => $query->where('telefone', 'like', "%{$telefone}%"))
                ->paginate();
        });

    }

    public function find(string $idPublic): Model|Builder
    {
        return $this->client->query()
            ->with('qsas')
            ->where('id_public', $idPublic)
            ->firstOrFail();
    }

    public function store(array $clientStoreData): void
    {
        try {
            DB::beginTransaction();
            $qsas = Arr::get($clientStoreData, 'qsa');
            $client = $this->client->query()->create($clientStoreData);

            if (!empty($qsas)) {
                foreach ($qsas as $qsaData) {
                    $this->storeQsa($qsaData, $client);
                }
            }
            DB::commit();
        } catch (Throwable $throwable) {
            Log::error($throwable->getMessage());
            DB::rollback();
            throw $throwable;
        }
    }

    public function update(array $updateClientData): void
    {
        $idPublic = Arr::get($updateClientData, 'id_public');
        $qsas = Arr::get($updateClientData, 'qsa');

        $client = $this->client->query()
            ->where('id_public', $idPublic)->first();

        $client->update([
            "cnpj" => Arr::get($updateClientData, 'cnpj'),
            "nome_fantasia" => Arr::get($updateClientData, 'nome_fantasia'),
            "email" => Arr::get($updateClientData, 'email'),
            "endereco" => Arr::get($updateClientData, 'endereco'),
            "cidade" => Arr::get($updateClientData, 'cidade'),
            "estado" => Arr::get($updateClientData, 'estado'),
            "pais" => Arr::get($updateClientData, 'pais'),
            "telefone" => Arr::get($updateClientData, 'telefone'),
            "area_atuacao_cnae" => Arr::get($updateClientData, 'area_atuacao_cnae'),
        ]);

        if (!empty($qsas)) {
            $this->detachQsa($client);
            foreach ($qsas as $qsaData) {
                $this->storeQsa($qsaData, $client);
            }
        }
        return;
    }

    public function delete(string $idPublic): void
    {
        try {
            DB::beginTransaction();
            $client = $this->find($idPublic);
            $this->detachQsa($client);
            $client->delete();
            DB::commit();
            return;
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::error($throwable->getMessage());
            throw $throwable;
        }
    }

    private function detachQsa(Client $client)
    {
        $qsaIds = $client->qsas()->pluck('qsa_id')->toArray();
        $client->qsas()->detach();
        $this->qsa->query()->whereIn('id', $qsaIds)->delete();
    }

    private function storeQsa(array $qsaData, Client $client): void
    {
        $qsa = Qsa::create([
            'nome' => $qsaData['nome'],
            'qualificacao' => $qsaData['qualificacao'],
        ]);
        $client->qsas()->attach($qsa->id);
    }
}
