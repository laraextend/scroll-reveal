<?php

namespace Laraextend\ScrollReveal;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Laraextend\ScrollReveal\Components\ScrollReveal;
use Laraextend\ScrollReveal\Components\ScrollRevealScripts;

class ScrollRevealServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/scroll-reveal.php', 'scroll-reveal');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'scroll-reveal');

        Blade::component('scroll-reveal', ScrollReveal::class);
        Blade::component('scroll-reveal-scripts', ScrollRevealScripts::class);

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/scroll-reveal.php' => config_path('scroll-reveal.php'),
            ], 'scroll-reveal-config');

            $this->publishes([
                __DIR__.'/../resources/js/scroll-reveal-driver.js'
                    => public_path('vendor/scroll-reveal/scroll-reveal-driver.js'),
            ], 'scroll-reveal-assets');
        }
    }
}
