<?php

namespace App\Providers;

use App\Domain\Client\Entities\Client;
use App\Observers\ClientObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {
    }

    public function boot(): void
    {
        Client::observe(ClientObserver::class);
    }
}
