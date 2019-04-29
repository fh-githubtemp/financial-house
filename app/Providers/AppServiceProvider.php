<?php

namespace App\Providers;

use App\Reporting\Client;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Client::class, function () {
            $httpClient = new \GuzzleHttp\Client([
                'base_uri' => Config::get('reporting_client.api.base_url'),
            ]);

            return new Client($httpClient);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
