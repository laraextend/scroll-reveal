<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Animation Settings
    |--------------------------------------------------------------------------
    |
    | These values are used as fallbacks when no prop is passed to the
    | <x-scroll-reveal> component. Override them in your app config or
    | by publishing this file via: php artisan vendor:publish --tag=scroll-reveal-config
    |
    */

    'animate'   => true,
    'animation' => 'fade-up',
    'duration'  => 700,
    'delay'     => 0,
    'as'        => 'div',

    /*
    |--------------------------------------------------------------------------
    | Driver Initialization Options
    |--------------------------------------------------------------------------
    |
    | These values are informational and document the options accepted by
    | <x-scroll-reveal-scripts> and the built-in scroll-reveal-driver.js.
    |
    | initClass  — CSS class the driver watches on elements (must match
    |              the value set by the component, default: "animateme").
    | offset     — Fraction of the element that must be visible before the
    |              animation fires (0.0 – 1.0, default: 0.2).
    | animateOut — Whether to re-animate elements when they leave the
    |              viewport and re-enter (default: false).
    |
    */

    'driver_options' => [
        'initClass'  => 'animateme',
        'offset'     => 0.2,
        'animateOut' => false,
    ],

];
