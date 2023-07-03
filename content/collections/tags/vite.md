---
id: aeec964c-ab02-48d1-997c-8f1e331204a3
blueprint: tag
title: Vite
description: 'Returns the path to a versioned Mix file'
intro: 'This tag is used in tandem with the Vite build tool to return the path to CSS and JavaScript files.'
parameters:
  -
    name: src
    type: string
    description: |
      The path to the file, relative to your project root. You may pass multiple files and paths.
  -
    name: directory
    type: string
    description: |
      The path to the desired build directory, relative to the `public` directory. Defaults to `build`.
  -
    name: hot
    type: string
    description: |
      The path to the desired location for the hot file, relative to your project root. Defaults to `public/hot`.
---
The `vite` tag is a wrapper around [Laravel's Vite integration](https://laravel.com/docs/vite). It is essentially an Antlers version of the `@vite` Blade directive.

You should pass in both the css and javascript paths, and it will output the appropriate html tags.

```
{{ vite src="resources/js/app.js|resources/css/app.css" }}
```

If you are running in development mode by running `npm run dev`, it will handle hot-reloading (e.g. save a css file, your page will update automatically without you refreshing).

```html
<script type="module" src="http://127.0.0.1:3000/@vite/client"></script>
<script type="module" src="http://127.0.0.1:3000/resources/js/site.js"></script>
<link rel="stylesheet" href="http://127.0.0.1:3000/resources/css/site.css"/>
```

Otherwise, it will use the compiled assets, which you would have done by running `npm run build`.

```html
<link rel="stylesheet" href="http://yoursite.com/build/assets/site.3bc13c9b.css"/>
<script type="module" src="http://yoursite.com/build/assets/site.67066a5d.js"></script>
```

Additionally, you can set custom locations for the build directory and hot file.

```
{{ vite src="resources/css/tailwind.css|resources/js/site.js" directory="bundle" hot="storage/vite.hot" }}
```
When using these options, please make sure to also adjust your `vite.config.js` file. More about advanced customization can be found in [Laravel's Vite docs](https://laravel.com/docs/9.x/vite#advanced-customization).

## Processing Static Assets With Vite

To process static assets in your Antlers files with Vite, as described in the [Laravel's Vite Docs](https://laravel.com/docs/master/vite#blade-processing-static-assets), you should use:

```html
<img src="{{ vite:asset src="resources/images/logo.png" }}">
```
