<?php

namespace App\Providers;

use App\Models\Competition;
use App\Models\Invoice;
use App\Policies\CompetitionPolicy;
use App\Policies\InvoicePolicy;
use App\Socialite\Wca\Provider;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Invoice::class => InvoicePolicy::class,
        Competition::class => CompetitionPolicy::class,
    ];
    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->bootWcaSocialite();
    }

    public function bootWcaSocialite()
    {
        $socialite = $this->app->make('Laravel\Socialite\Contracts\Factory');
        $socialite->extend(
            'wca',
            function ($app) use ($socialite) {
                return $socialite->buildProvider(Provider::class, [
                    'client_id' => config('services.wca.client_id'),
                    'client_secret' => config('services.wca.client_secret'),
                    'redirect' => config('services.wca.redirect'),
                ]);
            }
        );
    }
}
