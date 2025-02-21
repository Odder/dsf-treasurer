<?php

namespace App\Services\Wca;

use Carbon\Laravel\ServiceProvider;
use Illuminate\Support\Facades\Http;

class WcaServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('wcif-service', function ($app) {
            return new WcifService();
        });
    }

    public function boot()
    {
        Http::macro('wca', function () {
            return Http::baseUrl('https://www.worldcubeassociation.org/api/v0/');
        });
    }
}
