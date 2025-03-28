<?php

namespace App\Providers;

use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(UrlGenerator $url)
    {
        // force https
        if (env('APP_ENV') !== 'local') {
            $url->forceScheme('https');
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // force https
        if (env('APP_ENV') !== 'local') {
            $this->app['request']->server->set('HTTPS', true);
        }
    }
}
