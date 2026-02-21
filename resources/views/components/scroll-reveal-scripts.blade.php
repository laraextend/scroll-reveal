@if ($inline)
    {{-- Inline mode: embeds the driver directly — zero HTTP requests, works without any publish step --}}
    <script>{!! file_get_contents(__DIR__ . '/../../../../js/scroll-reveal-driver.js') !!}</script>
@else
    {{-- File mode: references the published asset at public/vendor/scroll-reveal/scroll-reveal-driver.js --}}
    <script src="{{ asset('vendor/scroll-reveal/scroll-reveal-driver.js') }}"></script>
@endif

<script>
(function () {
    var options = {
        initClass:  '{{ $initClass }}',
        offset:     {{ $offset }},
        animateOut: {{ $animateOut ? 'true' : 'false' }},
    };

    var driver;

    function init() {
        if (driver) driver.destroy();
        driver = new ScrollRevealDriver(options);
    }

    document.addEventListener('DOMContentLoaded', init);
    document.addEventListener('livewire:navigated', init);
})();
</script>
