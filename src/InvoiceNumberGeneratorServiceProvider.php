<?php

namespace Skycoder\InvoiceNumberGenerator;

use Illuminate\Support\ServiceProvider;

class InvoiceNumberGeneratorServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {

        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
    }
}
