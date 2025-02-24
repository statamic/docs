---
id: aeec964c-ab02-48d1-997c-8f1e331204a3
blueprint: tag
title: Vite
description: 'Returns the path to Vite assets'
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

You should pass in both the CSS and JavaScript paths, and it will output the appropriate html tags.

::tabs

::tab antlers
```antlers
{{ vite src="resources/js/app.js|resources/css/app.css" }}
```
::tab blade
```blade
<s:vite src="resources/js/app.js|resources/css/app.css" />
```
::

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

::tabs

::tab antlers
```antlers
{{ vite src="resources/css/tailwind.css|resources/js/site.js" directory="bundle" hot="storage/vite.hot" }}
```
::tab blade
```blade
<s:vite
  src="resources/css/tailwind.css|resources/js/site.js"
  directory="bundle"
  hot="storage/vite.hot"
/>
```
::

When using these options, please make sure to also adjust your `vite.config.js` file. More about advanced customization can be found in [Laravel's Vite docs](https://laravel.com/docs/12.x/vite#advanced-customization).

## Processing Static Assets With Vite

To process static assets in your Antlers files with Vite, as described in the [Laravel's Vite Docs](https://laravel.com/docs/master/vite#blade-processing-static-assets), you should use:

::tabs

::tab antlers
```antlers
<img src="{{ vite:asset src="resources/images/logo.png" }}">
```
::tab blade
```blade
<img src="{{ Vite::asset('resources/images/logo.png') }}">
```
::

## Arbitrary Attributes

If you need to include additional attributes in your script and style tags, such as the `data-turbo-track` attribute, you can pass them as parameters using the `attr:` prefix:

::tabs

::tab antlers
```antlers
{{ vite
  src="foo.js|bar.css"
  attr:data-turbo-track="reload"
  attr:async="true"
}}
```
::tab blade
```blade
<s:vite
  src="foo.js|bar.css"
  attr:data-turbo-track="reload"
  attr:async="true"
/>
```
::

You can also provide attributes that are specific to script or style tags:

::tabs

::tab antlers
```antlers
{{ vite
  src="foo.js|bar.css"

  attr:script:data-turbo-track="reload"
  attr:script:async="true"

  attr:style:data-turbo-track="reload"
  attr:style:integrity="false"
}}
```
::tab blade
```blade
<s:vite
  src="foo.js|bar.css"

  attr:script:data-turbo-track="reload"
  attr:script:async="true"

  attr:style:data-turbo-track="reload"
  attr:style:integrity="false"
/>
```
::