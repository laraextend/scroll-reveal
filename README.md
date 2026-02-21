<p align="center">
  <a href="https://packagist.org/packages/laraextend/scroll-reveal"><img src="https://img.shields.io/packagist/v/laraextend/scroll-reveal.svg?style=flat-square" alt="Latest Version on Packagist"></a>
  <a href="https://packagist.org/packages/laraextend/scroll-reveal"><img src="https://img.shields.io/packagist/dt/laraextend/scroll-reveal.svg?style=flat-square" alt="Total Downloads"></a>
  <a href="https://packagist.org/packages/laraextend/scroll-reveal"><img src="https://img.shields.io/packagist/php-v/laraextend/scroll-reveal.svg?style=flat-square" alt="PHP Version"></a>
  <a href="LICENSE.md"><img src="https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square" alt="License"></a>
</p>

# Laravel Scroll Reveal

**Scroll-triggered animations for Laravel Blade — powered by josh.js and Animate.css.**

`laraextend/scroll-reveal` provides a single, flexible `<x-scroll-reveal>` Blade component that wraps any content in a scroll-triggered animation. Built on top of [josh.js](https://techandmedia.in/josh-js/docs/) and [Animate.css](https://animate.style/), it works seamlessly in plain Blade templates and is fully Livewire-compatible.

---

## ✨ Features

- **🧩 One Blade Component** — `<x-scroll-reveal>` wraps any HTML content with scroll-triggered animations
- **🎨 30+ Animation Aliases** — Intuitive names (`fade-up`, `zoom-in`, `slide-left`, …) mapped to Animate.css classes
- **⚡ Livewire Ready** — All `wire:*`, `x-*` and `data-*` attributes are forwarded automatically
- **🏷️ Dynamic HTML Tag** — Render as any element (`div`, `section`, `article`, `span`, …) via the `as` prop
- **⏱️ Timing Control** — Fine-grained `duration` and `delay` props per element
- **🔇 Opt-Out Anywhere** — Pass `:animate="false"` to disable animation for a specific element at runtime
- **⚙️ Configurable Defaults** — Publish the config file to set project-wide defaults
- **📦 Zero Config** — Works immediately after installation with sensible defaults

---

## 📋 Requirements

- **PHP** >= 8.2
- **Laravel** >= 10.x
- **josh.js** >= 1.1 (loaded via CDN or bundler — see [JavaScript Setup](#javascript-setup))
- **Animate.css** >= 4.x (loaded via CDN or bundler — see [JavaScript Setup](#javascript-setup))

---

## 🚀 Installation

### 1. Install the package via Composer

```bash
composer require laraextend/scroll-reveal
```

> The ServiceProvider is registered automatically via Laravel's Auto-Discovery.

### 2. JavaScript Setup

This package only generates the HTML data-attributes that josh.js reads. You must include **josh.js** and **Animate.css** in your frontend yourself. Choose one of the two options below.

---

#### Option A — CDN (recommended for a quick start)

No npm install needed. Add directly to your layout file (e.g. `resources/views/layouts/app.blade.php`).

Inside `<head>`:

```html
<!-- Animate.css -->
<link
  rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
/>
```

Before the closing `</body>` tag:

```html
<!-- josh.js -->
<script src="https://unpkg.com/josh.js/dist/josh.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    new Josh({
      initClass: 'animateme',   // must match the class added by the component
      offset: 0.2,              // fraction of element visible before animating
      animateIn: true,
      animateOut: false,        // set to true to re-animate elements on scroll-out
    });
  });
</script>
```

---

#### Option B — npm + Vite bundler

**Step 1 — Install the npm packages** (required before any `import` statement will work):

```bash
npm install josh.js animate.css
```

> If you skip this step and add the `import` lines first, Vite will throw:
> `Failed to resolve import "josh.js" — Does the file exist?`
> Run the install command above and then restart `npm run dev`.

**Step 2 — Add the imports** to `resources/js/app.js`:

```js
import Josh from 'josh.js';
import 'animate.css';

document.addEventListener('DOMContentLoaded', () => {
  new Josh({
    initClass: 'animateme',
    offset: 0.2,
    animateIn: true,
    animateOut: false,
  });
});
```

**Step 3 — Restart the dev server:**

```bash
npm run dev
```

---

#### Livewire — re-initialize after navigation

When using Livewire's SPA navigation, josh.js must be re-initialized after each page transition. Add the `livewire:navigated` listener alongside your `DOMContentLoaded` handler:

```js
import Josh from 'josh.js';
import 'animate.css';

let josh;

function initJosh() {
  if (josh) josh.destroy?.();   // destroy the previous instance before creating a new one
  josh = new Josh({ initClass: 'animateme', offset: 0.2 });
}

document.addEventListener('DOMContentLoaded', initJosh);
document.addEventListener('livewire:navigated', initJosh);
```

### 3. Done!

No config files, no migrations, no additional steps required.

### 4. Optional Configuration

Publish the config file to set project-wide defaults:

```bash
php artisan vendor:publish --tag=scroll-reveal-config
```

Published file: `config/scroll-reveal.php`

---

## 🎬 Usage

### Basic usage

```blade
<x-scroll-reveal>
  <p>This fades in from below when it scrolls into view.</p>
</x-scroll-reveal>
```

### Custom animation & timing

```blade
<x-scroll-reveal animation="zoom-in" :duration="600" :delay="150">
  <div class="card">...</div>
</x-scroll-reveal>
```

### Full example with Tailwind classes

```blade
<x-scroll-reveal
  animate="true"
  animation="fade-up"
  :duration="550"
  :delay="200"
  class="container mx-auto px-4"
>
  <h2 class="text-3xl font-bold">Welcome</h2>
  <p class="mt-2 text-gray-600">Animated section content.</p>
</x-scroll-reveal>
```

### Different HTML tags

```blade
{{-- Renders as <section> --}}
<x-scroll-reveal as="section" animation="slide-up" class="py-16 bg-gray-50">
  ...
</x-scroll-reveal>

{{-- Renders as <article> --}}
<x-scroll-reveal as="article" animation="fade-right">
  ...
</x-scroll-reveal>
```

### Disable animation at runtime

```blade
<x-scroll-reveal :animate="false" class="container">
  {{-- No animation applied, just renders a plain <div> --}}
  ...
</x-scroll-reveal>
```

### Inside a Livewire component

All standard Blade and Livewire attributes pass through without extra configuration:

```blade
<x-scroll-reveal
  wire:key="feature-{{ $feature->id }}"
  animation="fade-up"
  :delay="$loop->index * 100"
  class="feature-card"
>
  <livewire:feature-card :feature="$feature" />
</x-scroll-reveal>
```

---

## 📐 Props Reference

| Prop        | Type     | Default     | Description                                                        |
|-------------|----------|-------------|--------------------------------------------------------------------|
| `animate`   | `bool`   | `true`      | Enable or disable the animation entirely.                          |
| `animation` | `string` | `'fade-up'` | Animation alias (see [Animation Aliases](#animation-aliases)).     |
| `duration`  | `int`    | `700`       | Animation duration in **milliseconds**.                            |
| `delay`     | `int`    | `0`         | Animation delay in **milliseconds** (0 = no delay).               |
| `as`        | `string` | `'div'`     | HTML tag to render (`div`, `section`, `article`, `span`, …).      |

All additional attributes (e.g. `class`, `id`, `wire:*`, `x-*`, `data-*`) are forwarded directly to the rendered element.

---

## 🎨 Animation Aliases

All aliases are mapped to their corresponding **Animate.css** class names used by josh.js.

### Fade

| Alias         | Animate.css class  |
|---------------|--------------------|
| `fade`        | `fadeIn`           |
| `fade-up`     | `fadeInUp`         |
| `fade-down`   | `fadeInDown`       |
| `fade-left`   | `fadeInRight`      |
| `fade-right`  | `fadeInLeft`       |

### Zoom

| Alias         | Animate.css class  |
|---------------|--------------------|
| `zoom-in`     | `zoomIn`           |
| `zoom-out`    | `zoomOut`          |
| `zoom-up`     | `zoomInUp`         |
| `zoom-down`   | `zoomInDown`       |
| `zoom-left`   | `zoomInRight`      |
| `zoom-right`  | `zoomInLeft`       |

### Slide

| Alias         | Animate.css class  |
|---------------|--------------------|
| `slide-up`    | `slideInUp`        |
| `slide-down`  | `slideInDown`      |
| `slide-left`  | `slideInRight`     |
| `slide-right` | `slideInLeft`      |

### Flip

| Alias         | Animate.css class  |
|---------------|--------------------|
| `flip-up`     | `flipInX`          |
| `flip-down`   | `flipInX`          |
| `flip-left`   | `flipInY`          |
| `flip-right`  | `flipInY`          |

### Rotate

| Alias          | Animate.css class    |
|----------------|----------------------|
| `rotate-in`    | `rotateIn`           |
| `rotate-left`  | `rotateInUpLeft`     |
| `rotate-right` | `rotateInUpRight`    |

### Creative / Special

| Alias        | Animate.css class   |
|--------------|---------------------|
| `swing-in`   | `jackInTheBox`      |
| `drop`       | `bounceInDown`      |
| `rise`       | `bounceInUp`        |
| `skew-left`  | `lightSpeedInRight` |
| `skew-right` | `lightSpeedInLeft`  |
| `blur-in`    | `zoomIn`            |

> Unknown aliases fall back to `fadeInUp`.

---

## ⚙️ Configuration

After publishing the config file, you can set project-wide defaults in `config/scroll-reveal.php`:

```php
return [
    'animate'   => true,
    'animation' => 'fade-up',
    'duration'  => 700,
    'delay'     => 0,
    'as'        => 'div',

    // Informational — use these values when initializing new Josh() in JS
    'josh_options' => [
        'initClass'  => 'animateme',
        'offset'     => 0.2,
        'animateIn'  => true,
        'animateOut' => false,
    ],
];
```

> Note: The component props override the config file defaults. The `josh_options` key is informational only — it is not automatically injected into JavaScript.

---

## 🔍 How It Works

1. The `<x-scroll-reveal>` Blade component renders a standard HTML element.
2. When `animate` is `true`, it adds the CSS class `animateme` and three `data-josh-*` attributes:

   ```html
   <div
     class="animateme your-classes"
     data-josh-anim-name="fadeInUp"
     data-josh-duration="550ms"
     data-josh-anim-delay="0.2s"
   >
     ...
   </div>
   ```

3. josh.js observes all `.animateme` elements using the **Intersection Observer API**.
4. When an element enters the viewport, josh.js reads the `data-josh-*` attributes and applies the corresponding Animate.css animation class.
5. When `animate` is `false`, no attributes are added and a plain element is rendered — identical to writing the tag directly in Blade.

---

## 🧪 Testing

```bash
composer install
./vendor/bin/pest
```

---

## 📄 License

MIT — see [LICENSE](LICENSE.md).
