<?php

namespace App\Domain\Client\Services;

use App\Domain\Client\Repositories\ClientRepositories;

class ClientServices
{
    public function __construct(
        private readonly ClientRepositories $clientRepositories
    ) {

    }

    public function all(array $filterParams)
    {
        return $this->clientRepositories->all($filterParams);
    }

    public function find(string $idPublic)
    {
        return $this->clientRepositories->find($idPublic);
    }

    public function store(array $storeClientData)
    {
        return $this->clientRepositories->store($storeClientData);
    }

    public function update(array $updateClientData)
    {
        return $this->clientRepositories->update($updateClientData);
    }

    public function delete(string $idPublic)
    {
        return $this->clientRepositories->delete($idPublic);
    }

}
