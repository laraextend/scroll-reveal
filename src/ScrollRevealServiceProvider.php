<?php

namespace Laraextend\ScrollReveal;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Laraextend\ScrollReveal\Components\ScrollReveal;

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

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/scroll-reveal.php' => config_path('scroll-reveal.php'),
            ], 'scroll-reveal-config');
        }
    }
}
