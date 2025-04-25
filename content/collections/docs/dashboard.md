---
title: Dashboard
intro: The dashboard is a user-customizable screen containing widgets. Lots of widgets, few widgets, custom widgets, or prebuilt widgets. All kinds of widgets.
template: page
blueprint: page
id: 249e046f-a9b4-494b-9e4d-084c28e01028
---
## Overview

When you log into the control panel, you will be taken to the dashboard &mdash; a customizable screen containing widgets. Widgets!

<figure>
    <img src="/img/dashboard.png" alt="Statamic Global Set Example">
    <figcaption>The dashboard and the Getting Started widget</figcaption>
</figure>

## Widgets

A widget can contain just about anything. _ANYTHING_ From a list of recent entries to an embedded iframe playing [Poolside.fm](https://poolside.fm). However, it probably makes sense to make and use widgets that have _something_ to do with your site. Like seeing draft or scheduled entries, recent form submissions, and if there are any software updates.

Statamic comes bundled with a [handful of widgets](/widgets), and you may also [create your own](/extending/widgets) or use ones created by others.

## Configuration

Widgets can be added to the dashboard by modifying the `widgets` array in `config/statamic/cp.php`.

``` php
'widgets' => [
    'getting_started',
    [
        'type' => 'collection',
        'collection' => 'blog',
        'width' => 50
    ],
    [
        'type' => 'collection',
        'collection' => 'pages',
        'width' => 50
    ]
],
```

Each item in the array should specify the widget as `type` along with any widget-specific settings. You can find what values are available on the respective widget's documentation page.

You may use the same widget multiple times, configured in different ways.

Each widget may have a `width` defined as a percentage.
`25`, `33`, `50`, `66`, `75`, and `100` (the default).

For widgets not requiring any configuration you can provide the string instead of an array, like the `getting_started` widget in the above example.
