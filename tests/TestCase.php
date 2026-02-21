<?php

namespace Laraextend\ScrollReveal\Tests;

use Laraextend\ScrollReveal\ScrollRevealServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            ScrollRevealServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('scroll-reveal.animate', true);
        $app['config']->set('scroll-reveal.animation', 'fade-up');
        $app['config']->set('scroll-reveal.duration', 700);
        $app['config']->set('scroll-reveal.delay', 0);
        $app['config']->set('scroll-reveal.as', 'div');
    }
}
