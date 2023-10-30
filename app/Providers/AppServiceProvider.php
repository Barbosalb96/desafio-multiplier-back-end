<?php

namespace App\Providers;

use App\Domain\Client\Entities\Client;
use App\Observers\ClientObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {
    }

    public function boot(): void
    {
        Paginator::useBootstrap();
        Client::observe(ClientObserver::class);
    }
}
