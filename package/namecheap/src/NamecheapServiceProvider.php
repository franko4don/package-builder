<?php

namespace Frank\Namecheap;

use Illuminate\Support\ServiceProvider;

class NamecheapServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/views', 'namecheap');;
        $this->publishes([
            __DIR__.'config/namecheap.php' => config_path('namecheap.php'),
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/namecheap.php', 'namecheap'
        );
    }
}
