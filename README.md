<p align="center">
  <a href="https://packagist.org/packages/laraextend/scroll-reveal"><img src="https://img.shields.io/packagist/v/laraextend/scroll-reveal.svg?style=flat-square" alt="Latest Version on Packagist"></a>
  <a href="https://packagist.org/packages/laraextend/scroll-reveal"><img src="https://img.shields.io/packagist/dt/laraextend/scroll-reveal.svg?style=flat-square" alt="Total Downloads"></a>
  <a href="https://packagist.org/packages/laraextend/scroll-reveal"><img src="https://img.shields.io/packagist/php-v/laraextend/scroll-reveal.svg?style=flat-square" alt="PHP Version"></a>
  <a href="LICENSE.md"><img src="https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square" alt="License"></a>
</p>

# Laravel Scroll Reveal

**Scroll-triggered animations for Laravel Blade — powered by Animate.css.**

`laraextend/scroll-reveal` provides a flexible `<x-scroll-reveal>` Blade component that wraps any content in a scroll-triggered animation. It ships with its own **zero-dependency JavaScript driver** (built on the native Intersection Observer API) and works seamlessly in plain Blade templates and Livewire.

> **No external JavaScript runtime required.** The package includes its own driver script (`scroll-reveal-driver.js`) — no third-party npm package needed.

---

## ✨ Features

- **🧩 One Blade Component** — `<x-scroll-reveal>` wraps any HTML content with scroll-triggered animations
- **🎬 Built-in JS Driver** — `<x-scroll-reveal-scripts>` injects a zero-dependency Intersection Observer driver — no npm package required
- **🎨 30+ Animation Aliases** — Intuitive names (`fade-up`, `zoom-in`, `slide-left`, …) mapped to Animate.css classes
- **⚡ Livewire Ready** — All `wire:*`, `x-*` and `data-*` attributes are forwarded automatically; re-initialized after `livewire:navigated`
- **🏷️ Dynamic HTML Tag** — Render as any element (`div`, `section`, `article`, `span`, …) via the `as` prop
- **⏱️ Timing Control** — Fine-grained `duration` and `delay` props per element
- **🔇 Opt-Out Anywhere** — Pass `:animate="false"` to disable animation for a specific element at runtime
- **⚙️ Configurable Defaults** — Publish the config file to set project-wide defaults
- **📦 Zero Config** — Works immediately after installation with sensible defaults

---

## 📋 Requirements

- **PHP** >= 8.2
- **Laravel** >= 10.x
- **Animate.css** >= 4.x — for the CSS keyframe animations (loaded via CDN or npm)

---

## 🚀 Installation

### 1. Install the package via Composer

```bash
composer require laraextend/scroll-reveal
```

> The ServiceProvider is registered automatically via Laravel's Auto-Discovery.

---

### 2. JavaScript Setup

This package generates the HTML `data-*` attributes for the animation driver. You have three options for the frontend setup — choose whichever fits your project.

---

#### Option A — Built-in driver (recommended, zero npm dependency)

The package ships its own Intersection Observer driver. Publish it to your `public/` directory once:

```bash
php artisan vendor:publish --tag=scroll-reveal-assets
```

This copies `scroll-reveal-driver.js` to `public/vendor/scroll-reveal/scroll-reveal-driver.js`.

Then add `<x-scroll-reveal-scripts>` and the Animate.css link to your layout (e.g. `resources/views/layouts/app.blade.php`):

Inside `<head>`:

```html
<!-- Animate.css -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/animate.css/animate.min.css" />
```

Before the closing `</body>` tag:

```blade
{{-- Loads the published driver + auto-initializes + handles livewire:navigated --}}
<x-scroll-reveal-scripts />
```

That is all. No npm install. No JS configuration. The component handles initialization and Livewire SPA navigation automatically.

**Available props for `<x-scroll-reveal-scripts>`:**

| Prop         | Type     | Default      | Description                                                    |
|--------------|----------|--------------|----------------------------------------------------------------|
| `initClass`  | `string` | `'animateme'`| CSS class the driver watches. Must match what the component sets.|
| `offset`     | `float`  | `0.2`        | Fraction of the element that must be visible to trigger (0–1). |
| `animateOut` | `bool`   | `false`      | Re-animate when an element leaves and re-enters the viewport.  |
| `inline`     | `bool`   | `false`      | Embed the driver script inline instead of referencing the file (useful if you skip the publish step). |

Inline mode (no publish step needed at all):

```blade
<x-scroll-reveal-scripts :inline="true" />
```

---

#### Option B — npm + Vite bundler (Animate.css only)

Use this option if you prefer to manage everything through your Vite build pipeline. The built-in driver is used for JavaScript — only Animate.css needs to be installed.

**Step 1 — Install Animate.css:**

```bash
npm install animate.css
```

**Step 2 — Publish the driver asset** (once):

```bash
php artisan vendor:publish --tag=scroll-reveal-assets
```

**Step 3 — Import the CSS** in your stylesheet (e.g. `resources/css/app.css`):

```css
@import 'animate.css';
```

**Step 4 — Add `<x-scroll-reveal-scripts>` to your layout** before `</body>`:

```blade
<x-scroll-reveal-scripts />
```

**Step 5 — Restart the dev server:**

```bash
npm run dev
```

---

#### Option C — CDN only (no build step, no npm)

Inside `<head>`:

```html
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/animate.css/animate.min.css" />
```

Before the closing `</body>` tag:

```blade
<x-scroll-reveal-scripts />
```

---

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

## 📐 `<x-scroll-reveal>` Props Reference

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

All aliases are mapped to their corresponding **Animate.css** class names.

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

    // Informational — mirrors the props of <x-scroll-reveal-scripts>
    'driver_options' => [
        'initClass'  => 'animateme',
        'offset'     => 0.2,
        'animateOut' => false,
    ],
];
```

> Note: The component props override the config defaults. The `driver_options` key is informational only — it is not automatically injected into JavaScript.

---

## 🔍 How It Works

1. The `<x-scroll-reveal>` Blade component renders a standard HTML element.
2. When `animate` is `true`, it adds the CSS class `animateme` and three `data-*` attributes:

   ```html
   <div
     class="animateme your-classes"
     data-sr-anim="fadeInUp"
     data-sr-duration="550ms"
     data-sr-delay="0.2s"
   >
     ...
   </div>
   ```

3. The JavaScript driver observes all `.animateme` elements via the **Intersection Observer API**.
4. When an element enters the viewport, the driver reads the `data-sr-*` attributes and applies the corresponding `animate__` CSS class from Animate.css.
5. When `animate` is `false`, no attributes are added — a plain element is rendered.

---

## 🧪 Testing

```bash
composer install
./vendor/bin/pest
```

---

## 📄 License

MIT — see [LICENSE](LICENSE.md).
