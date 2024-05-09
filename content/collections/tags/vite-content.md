---
id: 6f6bff0a-074e-4706-8427-669ad951e8e0
blueprint: tag
title: Vite:Content
description: 'Returns the contents of a Vite asset'
intro: 'This tag is used in tandem with the Vite build tool to return the contents of CSS and JavaScript files.'
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
---
The `vite:content` tag allows you to output the contents of a Vite asset. This is useful if you need to inline the contents of a CSS or JavaScript file.

```html
<style>
    {{ vite:content src="resources/css/app.css" }}
</style>

<script>
    {{ vite:content src="resources/js/app.js" }}
</script>
```

:::warning Psst!
The `vite:content` tag will only output the contents of "built" assets. This means that changes made while running `npm run dev` will not be reflected in the output.
:::

If you need to, you can also specify a custom build directory.

```
{{ vite src="resources/css/tailwind.css|resources/js/site.js" directory="bundle" }}
```

When using these options, please make sure to also adjust your `vite.config.js` file. More about advanced customization can be found in [Laravel's Vite docs](https://laravel.com/docs/9.x/vite#advanced-customization).
