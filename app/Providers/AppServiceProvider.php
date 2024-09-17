<?php
// app/Providers/AppServiceProvider.php

namespace App\Providers;

use App\Factories\PulsaFactory;
use App\Factories\PaketDataFactory;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(PulsaFactory::class, function ($app) {
            return new PulsaFactory();
        });

        $this->app->bind(PaketDataFactory::class, function ($app) {
            return new PaketDataFactory();
        });
    }

    public function boot()
    {
        //
    }
}
