<?php

namespace REINetwork\BriteVerify\ServiceProvider;

use Illuminate\Support\ServiceProvider;

class LaravelServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->package('reinetwork/briteverify');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->bindBriteVerify();
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['briteverify'];
    }

    /**
     * Create instance of the BriteVerify client configured
     * with the required API token.
     */
    protected function bindBriteVerify()
    {
        $this->app->bind(
            'briteverify',
            function ($app) {
                $token = $app['config']->get('briteverify::token');
                return new \REINetwork\BriteVerify\Client($token);
            }
        );
    }
}
