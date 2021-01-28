---
title: Widgets
stage: 'Gathering Knowledge'
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1585861788
id: 4b77c19b-129c-4271-a724-eea884eb3e2e
---
The dashboard of the Control Panel may contain any number of widgets. A widget can contain anything you can think of. From a list of recent entries to a randomized inspiration quote.

Statamic comes bundled with a handful of widgets, however you may also [create your own](https://statamic.dev/extending/widgets) or use ones created by others.

## Configuration
Widgets can be added to the dashboard by modifying the widgets array in the `config/statamic/cp.php` file.

Each item in the array should specify the widget as the type, plus any widget-specific configuration values. 

You may use the same widget multiple times, configured in different ways.

## Available Widgets

### Collection

Display a listing of entries from a collection

``` php
[
	'type' => 'collection',
	'collection' => 'blog', // name of your collection
	'width' => 100,
	'limit' => 10
]
```

### Form

Display a listing of form submissions.

``` php
[
	'type' => 'form',
	'form' => 'contact', // name of your form
    'fields' => ['name','email'], // the fields you want to display in the widget
	'width' => 100,
	'limit' => 10
]
```

### Updater

Will display if updates are available

``` php
[
	'type' => 'updater',
	'width' => 100,
]
```

## An example

``` php
'widgets' => [
    [
        'type' => 'collection',
        'collection' => 'blog',
        'width' => 50,
        'limit' => 10,
    ],
    [
        'type' => 'collection',
        'collection' => 'products',
        'width' => 50,
        'limit' => 10
    ],
    [
        'type' => 'form',
        'form' => 'contact',
        'fields' => ['name','email'],
        'width' => 100,
        'limit' => 20,
    ],
    [
        'type' => 'updater',
        'width' => '100',
    ],
],

```
