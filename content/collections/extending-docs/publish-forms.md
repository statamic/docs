---
title: 'Publish Forms'
intro: |
  Build custom forms by harnessing the power of Blueprints and fieldtypes.
stage: 1
id: b4b46ceb-9feb-4587-8f0d-2080511bf9e3
---

## Overview

When creating or editing content (entries, pages, etc), you are presented with a form view. This is what we call
the "Publish" form. You're free to use these in your own addons or custom features.

The publish form flow would essentially be this:

- Get a blueprint
- Get some data
- Blueprint performs some pre-processing on the data
- Pass them both along to a Vue component
- User hits save
- Blueprint does some validation
- Blueprint does some post-processing on the data
- Do something with the data

## Preparing for the front-end

For example's sake, we'll be using the publish form to update Eloquent models (a `Product` model), much like a typical Laravel application.

``` php
public function edit(Product $product)
{
    // Get an array of values from the item that you want to be populated
    // in the form. eg. ['title' => 'My Product', 'slug' => 'my-product']
    $values = $product->toArray();

    // Get a blueprint. This might come from an actual blueprint yaml file
    // or even defined in this class. Read more about blueprints below.
    $blueprint = $this->getBlueprint();

    // Get a Fields object, a representation of the fields in a blueprint
    // that factors in imported fieldsets, config overrides, etc.
    $fields = $blueprint->fields();

    // Add the values to the object. This will let you do things like
    // validation, and processing, which is about to happen.
    $fields = $fields->addValues($values);

    // Pre-process the values. This will convert the raw values into values
    // that the corresponding fieldtype vue components will be expecting.
    $fields = $fields->preProcess();

    // You'll probably prefer chaining all of that.
    // $fields = $blueprint->fields()->addValues($values)->preProcess();

    // The vue component will need these three values at a minimum.
    return view('form', [
        'blueprint' => $blueprint->toPublishArray(),
        'values'    => $fields->values(),
        'meta'      => $fields->meta(),
    ]);
}
```

## The front-end

Statamic provides an opinionated `PublishForm` that will render a form based on a blueprint, handle submitting it via AJAX,
handle validation, add a page title with breadcrumbs, and a bunch of other stuff.

You can put the component directly in your Blade view, or within another Vue component.

``` blade
@extends('statamic::layout')

@section('content')
    <publish-form
        title="My Form"
        action="{{ cp_route('test.update') }}"
        :blueprint='@json($blueprint)'
        :meta='@json($meta)'
        :values='@json($values)'
    ></publish-form>
@stop
```

> Using the `@json` Blade directive in element attributes like this requires that it be surrounded by single quotes.

Read more about [the publish form component](/extending/publish-components#form) to find out about its props and events.


## Handling the form submission

The Vue component on the front-end will submit back to a URL of your choosing.

``` php
public function update(Request $request, Product $product)
{
    $blueprint = $this->getBlueprint();

    // Get a Fields object, and populate it with the submitted values.
    $fields = $blueprint->fields()->addValues($request->all());

    // Perform validation. Like Laravel's standard validation, if it fails,
    // a 422 response will be sent back with all the validation errors.
    $fields->validate();

    // Perform post-processing. This will convert values the Vue components
    // were using into values suitable for putting into storage.
    $values = $fields->process()->values();

    // Do something with the values. Here we'll update the product model.
    $product->update($values);

    // Return something if you want. But it's not even necessary.
}
```

You've just rendered an item in form and handled updating it. Awesome!

> Since the values are being processed through the blueprint's fieldtypes, their values
> will be saved in such a way that you may need augmentation to use them.
> For instance, an assets fieldtype will save an array of paths relative to the configured
> asset container, and when augmented will return an array of Asset objects.
> So, you may want to make sure that when you retrieve your data later, that it's [augmented](/extending/augmentation).


## Blueprints

In the examples above, we just said "get a blueprint". There are a couple of ways to do this:

### Get an actual user defined blueprint

Get one from where all the blueprints are typically stored, by its handle.
If it doesn't exist, it'll return null.

``` php
use Statamic\Facades\Blueprint;

Blueprint::find('example'); // resources/blueprints/example.yaml
```

### Create one on the fly

If you're wanting a blueprint just for sake of rendering this one specific form, you can create it in PHP. No YAML file necessary.

Using the `makeFromFields` method, you can pass in an array of fields using the fieldset syntax:

``` php
Blueprint::makeFromFields([
    'title' => [
        'type' => 'text',
        'validate' => 'required',
        'width' => 50,
    ],
    'handle' => [
        'type' => 'text',
        'validate' => 'required|alpha_dash',
        'width' => 50,
    ],
]);
```

This will give you a blueprint with a single section (no tabs or sidebar).

If you want to get fancy, you can `make` a Blueprint manually. The `setContents` method will expect an array in Blueprint syntax.

``` php
Blueprint::make()->setContents([
    'sections' => [
        'main' => ['fields' => [
            ['handle' => 'title', 'field' => ['type' => 'text']],
            ['handle' => 'content', 'field' => ['type' => 'markdown']],
        ]],
        'sidebar' => ['fields' => [
            ['handle' => 'slug', 'field' => ['type' => 'slug']],
        ]]
    ]
]);
```
