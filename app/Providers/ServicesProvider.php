<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\ContractsService;

class ServicesProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ContractsService::class, ContractsService::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
