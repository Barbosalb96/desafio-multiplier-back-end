<?php

namespace App\Observers;

use App\Domain\Client\Entities\Client;
use Illuminate\Support\Facades\Cache;

class ClientObserver
{
    public function created(Client $client)
    {
        Cache::flush();
    }

    public function updated(Client $client)
    {
        Cache::flush();
    }

    public function deleted(Client $client)
    {
        Cache::flush();
    }
}
