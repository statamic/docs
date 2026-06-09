---
title: Building Widgets
template: page
updated_by: 42bb2659-2277-44da-a5ea-2f1eed146402
updated_at: 1569264107
id: 5900c99f-89b9-4ee3-834c-cb1b070146e4
---

## Generating a widget

You can generate a widget with a console command:

```shell
php please make:widget LocalWeather
```

This will automagically create a class in `app/Widgets` and a Vue component in `resources/js/components/widgets`.

The PHP class is responsible for returning the Vue component and any props:

```php
// app/Widgets/LocalWeather.php

<?php  
  
namespace App\Widgets;  
  
use Statamic\Widgets\VueComponent;
use Statamic\Widgets\Widget;
  
class LocalWeather extends Widget  
{
    public function component()  
    {  
        return VueComponent::render('LocalWeather', ['message' => 'Hello World!']);
    }  
}
```
```blade
<script setup>
import { Widget } from '@statamic/cms/ui';

defineProps(['message']);
</script>

<template>
    <Widget title="LocalWeather">
        <div class="px-4 py-3">
            <p>👋 {{ message }}</p>
        </div>
    </Widget>
</template>
```

The `<Widget>` component requires a `title` prop, along with optional `icon` and `href` props. You also pass an `actions` slot to render content in the top right of the widget.

If you'd prefer to create your widget using Blade, simply pass the `--blade` argument to the `make:widget` command.

## Configuring

Widgets can be added to the dashboard by modifying the `widgets` array in the `config/statamic/cp.php` file.

``` php
// config/statamic/cp.php
'widgets' => [
  [ // [tl! focus:start]
      'type' => 'local_weather',
      'width' => 100,
  ], // [tl! focus:end]
],
```
