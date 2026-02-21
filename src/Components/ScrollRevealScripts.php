<?php

namespace Laraextend\ScrollReveal\Components;

use Illuminate\View\Component;

class ScrollRevealScripts extends Component
{
    /**
     * @param string $initClass  CSS class watched by the driver. Must match what <x-scroll-reveal> sets.
     * @param float  $offset     Intersection threshold (0.0 – 1.0).
     * @param bool   $animateOut Re-animate elements each time they re-enter the viewport.
     * @param bool   $inline     Inline the driver script directly instead of referencing the published file.
     */
    public function __construct(
        public readonly string $initClass  = 'animateme',
        public readonly float  $offset     = 0.2,
        public readonly bool   $animateOut = false,
        public readonly bool   $inline     = false,
    ) {}

    public function render(): \Illuminate\Contracts\View\View
    {
        return view('scroll-reveal::components.scroll-reveal-scripts');
    }
}
