<?php

namespace App\Http\Controllers\Web;

use App\Domain\Client\Services\ClientServices;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\ClientFilterRequest;

class DashboardController extends Controller
{
    public function __construct(
        private readonly ClientServices $clientServices
    )
    {
    }

    public function index(ClientFilterRequest $clientFilterRequest)
    {
        $paramsFilter = $clientFilterRequest->validated();
        $data = $this->clientServices->all($paramsFilter);
        return view('Dashboard.index', compact('data'));
    }

    public function show(string $idPublic)
    {
        $client = $this->clientServices->find($idPublic);
        return view('Detail.detail', compact('client'));
    }


}
