<?php

namespace App\Providers;

use App\Models\Invoice;
use App\Observers\InvoiceObserver;
use App\Services\Wca\Competitions;
use App\Services\Wca\WcaServiceProvider;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // register WCA services
        $this->app->singleton(Competitions::class, function ($app) {
            return new Competitions();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        Invoice::observe(InvoiceObserver::class);

        $this->app->register(WcaServiceProvider::class);

        Carbon::setLocale('da');
        App::setLocale('da');
    }
}
