---
id: 5f26a634-19ae-4413-8b9e-1ed9c2c76bb0
blueprint: page
title: 'Vite Tooling'
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
- The `@statamic/cms` package allows you to import Vue components from Statamic. As it's not a "real" npm package, the code is being pulled from your addon's `vendor` directory.

```json
{
    "private": true,
    "scripts": {
        "dev": "vite",
        "build": "vite build"
    },
    "dependencies": {
        "@statamic/cms": "file:./vendor/statamic/cms/resources/dist-package"
    },
    "devDependencies": {
        "laravel-vite-plugin": "^1.2.0",
        "vite": "^6.3.4"
    }
}
```

:::tip Note
If you aren't already, your addon should require `statamic/cms` as a Composer dependency. Otherwise, the `vendor/statamic/cms` directory won't exist.
:::

### vite.config.js
Here's `vite.config.js`, which configures Vite itself.

- The Laravel Vite plugin defaults to the `public` directory to place the compiled code because it's intended to be used in your app. We've changed it to `resources/dist` as we think it's a nicer convention when using in an addon. Of course, you may customize it. Whichever directory you choose, you'll need to make sure it exists.
- The `statamic` plugin allows you to import Statamic's Vue components and CSS files.

```js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import statamic from '@statamic/cms/vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/addon.js',
                'resources/css/addon.css'
            ],
            publicDirectory: 'resources/dist',
        }),
        statamic(),
    ],
});
```

### addon.js
The `addon.js` file is responsible for registering Vue components or hooks.

- Wrap any component registrations inside a `Statamic.booting()` callback to ensure components are registered _after_ Statamic has booted.
- Use `Statamic.$components.register()` (or `Statamic.$inertia.register()` for Inertia.js pages) to register components.

``` js
// import YourComponent from './components/YourComponent.vue';

Statamic.booting(() => {
    // Statamic.$components.register('component-name', YourComponent);
});
```

### addon.css
True to its name, the `addon.css` file is responsible for your addon's CSS.

```css
/** Your custom styles go here */
```

#### Tailwind CSS

If you want to use [Tailwind CSS](https://tailwindcss.com) in your addon's components, you'll need to install & configure Tailwind.

1. First, install `tailwindcss` and `@tailwindcss/vite`:
    ```sh
    npm install tailwindcss @tailwindcss/vite
    ```

2. Add the Tailwind Vite plugin to your `vite.config.js` file:

    ```js
    import { defineConfig } from 'vite';
    import laravel from 'laravel-vite-plugin';
    import statamic from '@statamic/cms/vite-plugin';
    import tailwindcss from '@tailwindcss/vite'; // [tl! ++ **]

    export default defineConfig({
        plugins: [
            laravel({
                input: [
                    'resources/js/addon.js',
                    'resources/css/addon.css'
                ],
                publicDirectory: 'resources/dist',
            }),
            statamic(),
            tailwindcss(),  // [tl! ++ **]
        ],
    });
    ```

3. In your addon's CSS file, import Statamic's `tailwind.css` file:
    ```css
    @import "@statamic/cms/tailwind.css";
    ```

    You don't need to `@import "tailwindcss"`, as it'll be imported by Statamic's `tailwind.css` file.

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

## Development

If you visit the Control Panel before running any commands, you will be greeted with a `Vite manifest not found` error. You'll need to install dependencies (the first time only) and start the development server.

```bash
cd addons/your/addon
npm install
npm run dev
```

Now that the Vite server is running, the error in the Statamic CP should be gone once you refresh.

To use Hot Module Reloading (HMR) or the [Vue Devtools](https://devtools.vuejs.org) browser extension, you need to publish a special "dev build", which can be done via the `vendor:publish` command:

```bash
php artisan vendor:publish --tag=statamic-cp-dev
```

Alternatively, it can be symlinked:

```bash
ln -s /path/to/vendor/statamic/cms/resources/dist-dev public/vendor/statamic/cp-dev
```

Statamic will use the dev build as long as `APP_DEBUG=true` in your `.env` and the `public/vendor/statamic/cp-dev` directory exists. You **shouldn't** commit these or use this on production.

:::tip
If you're using Herd or Valet with a secured site, your JS might not be loading correctly due to access control checks. You'll need Vite know about your Laravel site in `vite.config.js`.

```js
export default defineConfig({
    plugins: [
        laravel({
            detectTls: 'yoursite.test', // [tl!++]
            input: [
```
:::

To avoid needing to run the development script every time you visit the Control Panel, you may wish to build your CSS & JS.

```bash
npm run build
```

You may need to symlink your addon's `resources/dist` directory the first time so it points to your addon's directory:

```bash
ln -s ./addons/your/addon/resources/dist public/vendor/package
```

## Deployment

When you're ready to deploy your addon, either to your own application or getting it ready to go into the marketplace, you should compile the production assets.

Make sure that the Vite dev server is not running, then run:

```bash
npm run build
```

The files will be compiled into `resources/dist`.

If you'd like to test that everything is working you can run `php artisan vendor:publish` in your app and choose your addon's tag. The compiled assets should be copied into `public/vendor/your-addon` and they should be loaded in the Control Panel.
