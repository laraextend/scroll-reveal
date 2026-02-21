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
    | Josh.js Initialization Options
    |--------------------------------------------------------------------------
    |
    | These values are informational and document the recommended josh.js
    | initialization options. Pass them to new Josh() in your JavaScript.
    |
    | initClass  — CSS class that josh.js watches on elements (must match
    |              the value set by the component, default: "animateme").
    | offset     — Fraction of the element that must be visible before the
    |              animation fires (0.0 – 1.0, default: 0.2).
    | animateIn  — Whether to animate elements on scroll-in (default: true).
    | animateOut — Whether to re-animate elements when they leave the
    |              viewport and re-enter (default: false).
    |
    */

    'josh_options' => [
        'initClass'  => 'animateme',
        'offset'     => 0.2,
        'animateIn'  => true,
        'animateOut' => false,
    ],

];
