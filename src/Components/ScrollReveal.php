<?php

namespace Laraextend\ScrollReveal\Components;

use Illuminate\View\Component;

class ScrollReveal extends Component
{
    /**
     * Maps package animation aliases to Animate.css class names.
     */
    private static array $animationMap = [
        // Fade
        'fade'         => 'fadeIn',
        'fade-up'      => 'fadeInUp',
        'fade-down'    => 'fadeInDown',
        'fade-left'    => 'fadeInRight',   // starts right, moves left
        'fade-right'   => 'fadeInLeft',    // starts left, moves right
        // Zoom
        'zoom-in'      => 'zoomIn',
        'zoom-out'     => 'zoomOut',
        'zoom-up'      => 'zoomInUp',
        'zoom-down'    => 'zoomInDown',
        'zoom-left'    => 'zoomInRight',
        'zoom-right'   => 'zoomInLeft',
        // Flip
        'flip-up'      => 'flipInX',
        'flip-down'    => 'flipInX',
        'flip-left'    => 'flipInY',
        'flip-right'   => 'flipInY',
        // Rotate
        'rotate-in'    => 'rotateIn',
        'rotate-left'  => 'rotateInUpLeft',
        'rotate-right' => 'rotateInUpRight',
        // Slide
        'slide-up'     => 'slideInUp',
        'slide-down'   => 'slideInDown',
        'slide-left'   => 'slideInRight',
        'slide-right'  => 'slideInLeft',
        // Creative combos
        'swing-in'     => 'jackInTheBox',
        'drop'         => 'bounceInDown',
        'rise'         => 'bounceInUp',
        'skew-left'    => 'lightSpeedInRight',
        'skew-right'   => 'lightSpeedInLeft',
        'blur-in'      => 'zoomIn',
    ];

    /**
     * The resolved Animate.css animation name (e.g. "fadeInUp").
     */
    public readonly string $animName;

    /**
     * The resolved animation delay string (e.g. "0.2s"), or null when no delay.
     */
    public readonly ?string $animDelay;

    /**
     * @param bool   $animate   Whether to apply scroll-reveal animation at all.
     * @param string $animation One of the supported animation aliases (e.g. "fade-up").
     * @param int    $delay     Animation delay in milliseconds (0 = no delay).
     * @param int    $duration  Animation duration in milliseconds.
     * @param string $as        HTML tag to render (div, section, article, span, …).
     */
    public function __construct(
        public readonly bool $animate = true,
        public readonly string $animation = 'fade-up',
        public readonly int $delay = 0,
        public readonly int $duration = 700,
        public readonly string $as = 'div',
    ) {
        $this->animName  = self::$animationMap[$animation] ?? 'fadeInUp';
        $this->animDelay = $delay > 0 ? ($delay / 1000).'s' : null;
    }

    /**
     * Returns the data-attributes array the scroll-reveal driver reads.
     * Returns an empty array when animations are disabled.
     */
    public function animAttributes(): array
    {
        if (! $this->animate) {
            return [];
        }

        $attrs = [
            'class'           => 'animateme',
            'data-sr-anim'    => $this->animName,
            'data-sr-duration' => "{$this->duration}ms",
        ];

        if ($this->animDelay !== null) {
            $attrs['data-sr-delay'] = $this->animDelay;
        }

        return $attrs;
    }

    /**
     * Returns the list of all supported animation aliases.
     */
    public static function supportedAnimations(): array
    {
        return array_keys(self::$animationMap);
    }

    public function render(): \Illuminate\Contracts\View\View
    {
        return view('scroll-reveal::components.scroll-reveal');
    }
}
