<?php

namespace App\Http\Controllers\Api;

use App\Domain\Client\Services\ClientServices;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\ClientFilterRequest;
use App\Http\Requests\V1\ClientStoreRequest;
use App\Http\Requests\V1\ClientUpdateRequest;
use App\Http\Resources\V1\ClientResource;
use App\Http\Resources\V1\MessageResource;
use Symfony\Component\HttpFoundation\Response;

class ClientController extends Controller
{
    public function __construct(
        private readonly ClientServices $clientServices
    ) {

    }

    public function all(ClientFilterRequest $clientFilterRequest)
    {
        return $this->handleExceptions(function () use ($clientFilterRequest) {
            $response = $this->clientServices->all($clientFilterRequest->validated());
            return ClientResource::collection($response)
                ->response();
        });
    }

    public function find(string $idPublic)
    {
        return $this->handleExceptions(function () use ($idPublic) {
            $response = $this->clientServices->find($idPublic);
            return (new ClientResource($response))
                ->response();
        });
    }

    public function store(ClientStoreRequest $clientStoreRequest)
    {
        return $this->handleExceptions(function () use ($clientStoreRequest) {
            $this->clientServices->store($clientStoreRequest->validated());

            $message = [
                'message' => 'Client successfully',
            ];

            return (new MessageResource($message))
                ->response();
        });
    }

    public function update(ClientUpdateRequest $clientUpdateRequest)
    {
        return $this->handleExceptions(function () use ($clientUpdateRequest) {
            $this->clientServices->update($clientUpdateRequest->validated());

            $message = [
                'message' => 'Client updated successfully',
            ];

            return (new MessageResource($message))
                ->response();
        });
    }

    public function delete(string $idPublic)
    {
        return $this->handleExceptions(function () use ($idPublic) {
            $this->clientServices->delete($idPublic);
            $message = [
                'message' => 'Client deleted successfully',
            ];

            return (new MessageResource($message))
                ->response();
        });
    }
}
