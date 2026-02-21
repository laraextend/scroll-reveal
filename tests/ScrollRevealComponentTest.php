<?php

use Laraextend\ScrollReveal\Components\ScrollReveal;

// ---------------------------------------------------------------------------
// Component instantiation & prop defaults
// ---------------------------------------------------------------------------

it('has correct default props', function () {
    $component = new ScrollReveal();

    expect($component->animate)->toBeTrue()
        ->and($component->animation)->toBe('fade-up')
        ->and($component->delay)->toBe(0)
        ->and($component->duration)->toBe(700)
        ->and($component->as)->toBe('div');
});

it('resolves the correct josh.js animation name for known aliases', function (string $alias, string $expected) {
    $component = new ScrollReveal(animation: $alias);
    expect($component->joshAnim)->toBe($expected);
})->with([
    ['fade',        'fadeIn'],
    ['fade-up',     'fadeInUp'],
    ['fade-down',   'fadeInDown'],
    ['zoom-in',     'zoomIn'],
    ['zoom-out',    'zoomOut'],
    ['slide-up',    'slideInUp'],
    ['slide-down',  'slideInDown'],
    ['flip-up',     'flipInX'],
    ['flip-left',   'flipInY'],
    ['rotate-in',   'rotateIn'],
    ['drop',        'bounceInDown'],
    ['rise',        'bounceInUp'],
    ['swing-in',    'jackInTheBox'],
    ['skew-left',   'lightSpeedInRight'],
    ['skew-right',  'lightSpeedInLeft'],
    ['blur-in',     'zoomIn'],
]);

it('falls back to fadeInUp for unknown animation aliases', function () {
    $component = new ScrollReveal(animation: 'unknown-alias');
    expect($component->joshAnim)->toBe('fadeInUp');
});

// ---------------------------------------------------------------------------
// Delay handling
// ---------------------------------------------------------------------------

it('sets joshDelay to null when delay is 0', function () {
    $component = new ScrollReveal(delay: 0);
    expect($component->joshDelay)->toBeNull();
});

it('converts delay from milliseconds to seconds string', function () {
    $component = new ScrollReveal(delay: 200);
    expect($component->joshDelay)->toBe('0.2s');
});

it('converts delay of 1000ms to 1s', function () {
    $component = new ScrollReveal(delay: 1000);
    expect($component->joshDelay)->toBe('1s');
});

// ---------------------------------------------------------------------------
// animAttributes() output
// ---------------------------------------------------------------------------

it('returns full attributes array when animate is true', function () {
    $component = new ScrollReveal(
        animate: true,
        animation: 'fade-up',
        delay: 200,
        duration: 550,
    );

    $attrs = $component->animAttributes();

    expect($attrs)->toMatchArray([
        'class'               => 'animateme',
        'data-josh-anim-name' => 'fadeInUp',
        'data-josh-duration'  => '550ms',
        'data-josh-anim-delay' => '0.2s',
    ]);
});

it('omits data-josh-anim-delay when delay is 0', function () {
    $component = new ScrollReveal(animate: true, delay: 0);

    $attrs = $component->animAttributes();

    expect($attrs)->toHaveKey('class')
        ->and($attrs)->not->toHaveKey('data-josh-anim-delay');
});

it('returns empty array when animate is false', function () {
    $component = new ScrollReveal(animate: false);

    expect($component->animAttributes())->toBe([]);
});

// ---------------------------------------------------------------------------
// supportedAnimations() helper
// ---------------------------------------------------------------------------

it('returns all supported animation aliases as an array', function () {
    $animations = ScrollReveal::supportedAnimations();

    expect($animations)->toContain('fade-up', 'zoom-in', 'slide-left', 'flip-up', 'drop');
});

// ---------------------------------------------------------------------------
// ServiceProvider registration
// ---------------------------------------------------------------------------

it('registers the scroll-reveal blade component', function () {
    // Verifies that the service provider booted successfully and the
    // component alias is resolvable.
    $aliases = app('blade.compiler')->getClassComponentAliases();
    expect($aliases)->toHaveKey('scroll-reveal');
});

it('merges the package config correctly', function () {
    expect(config('scroll-reveal.animate'))->toBeTrue()
        ->and(config('scroll-reveal.animation'))->toBe('fade-up')
        ->and(config('scroll-reveal.duration'))->toBe(700)
        ->and(config('scroll-reveal.delay'))->toBe(0)
        ->and(config('scroll-reveal.as'))->toBe('div');
});
