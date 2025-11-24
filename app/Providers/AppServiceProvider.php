<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Siempre que estemos detrás de un proxy confiable
        if ($this->app->environment('production')) {
            URL::forceScheme('https');   // ← generará https:// para assets
            Request::setTrustedProxies(
                ['127.0.0.1',       // localhost
                    $this->app['request']->server->get('REMOTE_ADDR')], // Railway balancer
                Request::HEADER_X_FORWARDED_AWS_ELB   // compatible con Railway
            );
        }
    }
}
