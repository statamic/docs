---
id: 5f26a634-19ae-4413-8b9e-1ed9c2c76bb0
blueprint: page
title: 'Vite in Addons'
template: page
intro: 'How to use Vite in your addon.'
---

## Files
We recommend using Vite to manage your addon's asset build process. To use Vite, you'll need the following files inside your addon.

``` files theme:serendipity-light
your-addon/
    resources/
        dist/
        js/
            addon.js
        css/
            addon.css
    src/
        ServiceProvider.php
    vite.config.js
    package.json
```

### package.json
Here's `package.json`, which contains the commands you'll need to run, and the dependencies needed to run Vite.

- The `laravel-vite-plugin` package allows a simpler wrapper around common Vite options, and provides hot reloading.
- The `@vitejs/plugin-vue2` package allows you to use Vue v2 in your code. Vue v2 is used because that's the version used in the Control Panel. If you aren't adding Vue components to the CP you can leave this out.

```json
{
    "private": true,
    "scripts": {
        "dev": "vite",
        "build": "vite build"
    },
    "devDependencies": {
        "@vitejs/plugin-vue2": "^2.2.0",
        "laravel-vite-plugin": "^0.7.2",
        "vite": "^4.0.0"
    }
}
```

### vite.config.js
Here's `vite.config.js`, which configures Vite itself.

- The Laravel Vite plugin defaults to the `public` directory to place the compiled code because it's intended to be used in your app. We've changed it to `resources/dist` as we think it's a nicer convention when using in an addon. Of course, you may customize it. Whichever directory you choose, you'll need to make sure it exists.
- If you aren't using Vue components in the CP, you may omit the `vue` plugin and its import.

```js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue2';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/addon.js',
                'resources/css/addon.css'
            ],
            publicDirectory: 'resources/dist',
        }),
        vue(),
    ],
});
```

### Service Provider
Here's `ServiceProvider.php`, which is the PHP entry point to your addon. You should add a `$vite` property which mirrors the paths in your `vite.config.js` file.

```php
class ServiceProvider extends AddonServiceProvider
{
    protected $vite = [ // [tl! ++:start]
        'input' => [
            'resources/js/addon.js',
            'resources/css/addon.css',
        ],
        'publicDirectory' => 'resources/dist',
    ]; // [tl! ++:end]
}
```

:::tip
If you use the `php please make:fieldtype` command, these files will be created automatically for you.
:::

## Tailwind

If you use Tailwind in your addon views, you probably want to scan those files for any classes. Make sure to update the following files:

### package.json

Include Tailwind and postcss in your `package.json`.
```json
{
    "private": true,
    "scripts": {
        "dev": "vite",
        "build": "vite build"
    },
    "type": "module",
    "author": "Studio 1902",
    "devDependencies": {
        "laravel-vite-plugin": "^0.7.2",
        "postcss": "^8.4.35",
        "tailwindcss": "^3.4.1",
        "vite": "^4.0.0"
    }
}
```

### postcss.config.js

```js
export default {
    plugins: {
        tailwindcss: {}
    },
};
```

### tailwind.config.js

Add any paths you want to scanned for Tailwind classes to the content array.

```js
module.exports = {
  content: [
    './resources/views/widgets/**/*.blade.php',
  ]
}
```

### addon.css

Only include Tailwind utilities so you don't override any default CP styling.

```css
@import "tailwindcss/utilities";
```

## Development

If you visit the Control Panel before running any commands, you will be greeted with a `Vite manifest not found` error. You'll need to install dependencies (the first time only) and start the development server.

```bash
npm install
npm run dev
```

Now that the Vite server is running, the error in the Statamic CP should be gone once you refresh.

With the development server running, hot reloading should be working. When you save a CSS or JS file, it should be reflected in the browser without you needing to manually refresh.

:::tip
If you're using Valet with a secured site, your JS might not be loading correctly due to access control checks. You'll need Vite know about your Laravel site in `vite.config.js`.

```js
export default defineConfig({
    plugins: [
        laravel({
            valetTls: 'yoursite.test', // [tl!++]
            input: [
```
:::

## Deployment

When you're ready to deploy your addon, either to your own application or getting it ready to go into the marketplace, you should compile the production assets.

Make sure that the Vite dev server is not running, then run:

```bash
npm run build
```

The files will be compiled into `resources/dist`.

If you'd like to test that everything is working you can run `php artisan vendor:publish` in your app and choose your addon's tag. The compiled assets should be copied into `public/vendor/your-addon` and they should be loaded in the Control Panel.
