---
title: 'Control Panel'
template: page
parent: caf2a160-de1c-11e9-aaef-0800200c9a66
updated_by: 42bb2659-2277-44da-a5ea-2f1eed146402
updated_at: 1569263726
id: cb8f4d8a-47b6-4567-9510-ed7d9ee9c037
intro: The control panel may be customized in a number of different ways. You may add new fieldtypes, widgets, a stylesheet, or maybe you just want to add some arbitrary Javascript.
---

If you're [creating an addon](/extending/addons), they will have their own ways to add things to the Control Panel. This guide is for adding for your own app.

## Adding CSS and JS assets

Statamic can load extra stylesheets and Javascript files located in the `public/vendor/` directory.

You may register an asset to be loaded in the Control Panel using the `script` and `style` methods. This will accept a vendor name and a path.

For your application specific modifications, `app` will probably do just fine as a vendor name.

``` php
use Statamic\Statamic;

class AppServiceProvider
{
    public function boot
    {
        Statamic::script('app', 'cp.js');
        Statamic::style('app', 'cp.css');
    }
}
```

These commands will make Statamic expect files at `public/vendor/app/js/cp.js` and `public/vendor/app/css/cp.css` respectively.

## Adding assets to your build process

Rather than writing flat CSS and JS files directly into the `public` directory, you can (and should) set up source files that output there instead.

Add the following to your `webpack.mix.js`, adjusting the location of your source files as necessary:

``` js
mix.js('resources/js/cp.js', 'public/vendor/app/js')
   .sass('resources/sass/cp.scss', 'public/vendor/app/css');
```

The `cp.js` in this example may be your entry point for loading various other files. For instance, you could import fieldtypes:

``` files
resources/
`-- js/
    |-- cp.js
    `-- components/
        `-- fieldtypes/
            `-- Password.vue
```

``` js
// resources/js/cp.js
import Password from './components/fieldtypes/Password.vue';

Statamic.booting(() => {
    Statamic.$components.register('password-fieldtype', Password);
});
```

``` vue
// resources/js/components/fieldtypes/Password.vue
<template>
    ...
</template>
<script>
export default {
    //
}
</script>
```

> You may of course change filenames and folder structure, and even your entire build process. The thing that's important is that the compiled files are imported using `Statamic::script()`
