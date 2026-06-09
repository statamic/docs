---
title: 'Publish Forms'
intro: |
  Build custom forms by harnessing the power of Blueprints and Fieldtypes.
id: b4b46ceb-9feb-4587-8f0d-2080511bf9e3
---

## Overview

When creating or editing content (entries, pages, etc), you are presented with a form view. This is what we call the "Publish" form. You're free to use these in your own addons or custom features.

The publish form flow looks like this:

- Get a blueprint
- Get some data
- Blueprint performs some pre-processing on the data
- Pass them both along to a Vue component
- User hits save
- Blueprint does some validation
- Blueprint does some post-processing on the data
- Do something with the data

The required components depends on the complexity of what you're building.

- Very simple forms may not need any Vue or JavaScript at all, and could simply use the `PublishForm` class directly from your controller.
- If you need JavaScript or Vue, the `PublishContainer` component can be paired with blueprint data to render an entire form.
- The `PublishContainer` component can have its contents overridden if you need more control over the layout or behavior of the form.

## Simple Forms

You can create a basic Publish Form without having to think about Vue or Blade. 

You'll need a route and a controller. The controller needs to get the blueprint and its values, as well as store the updated values.

For example, if you wanted to create a Publish Form for an Eloquent model, the code might look like this:

```php
use Statamic\Facades\Blueprint;

class Product extends Model
{
    public function values(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
        ];       
    }

    public function blueprint()
    {
        return Blueprint::make(...);
    }
}
```

```php
Route::get('products/{product}', [ProductController::class, 'edit'])->name('product.edit');
Route::patch('products/{product}', [ProductController::class, 'update'])->name('product.update');
```

```php
use App\Models\Product;
use Illuminate\Support\Request;
use Statamic\CP\PublishForm;

class ProductController
{
    public function edit(Product $product)
    {
        return PublishForm::make($product->blueprint())
            ->values($product->values())
            ->submittingTo(cp_route('product.update', $product));
    }

    public function update(Request $request, Product $product)
    {
        $values = PublishForm::make($product->blueprint())->submit($request->all());
        
        $product->update($values);
    }
}
```

The `PublishForm` class accepts various other methods:

| Method                        | Description                                                       |
|-------------------------------|-------------------------------------------------------------------|
| `title($title)`               | Title of the publish form page.                                   |
| `icon($icon)`                 | Icon to be shown in the header, next to the page title.           |
| `values($values)`             | The publish form values.                                          |
| `parent($parent)`             | Provides a "parent" object to the fieldtypes                      |
| `readOnly()`                  | Marks the publish form as read-only.                              |
| `asConfig()`                  | Marks it as a "config" form, which renders slightly differently.  |
| `submittingTo($url, $method)` | Specify the submission URL and HTTP method (defaults to `PATCH`). |

## Complex Forms

For more complex forms, you can use the underlying components to build out the functionality you need.

You'll need a route and controller on the backend, and a Vue component on the frontend responsible for holding the form's values and submitting them somewhere.

### Preparing for the front-end

For example's sake, we'll be using the publish form to update Eloquent models (a `Product` model), much like a typical Laravel application.

```php
Route::get('products/{product}', [ProductController::class, 'edit'])->name('product.edit');
Route::patch('products/{product}', [ProductController::class, 'update'])->name('product.update');
```

``` php
use App\Models\Product;
use Inertia\Inertia;

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
    
    // We're returning a Vue component here with Inertia. We're passing 
    // the blueprint, the values and the meta.
    return Inertia::render('app::Products/Edit', [
        'blueprint' => $blueprint->toPublishArray(),
        'initialValues' => $fields->values(),
        'initialMeta' => $fields->meta(),
    ]);
}
```

:::tip
If you haven't already, now is a good time to [set up JavaScript & Vite](https://v6.statamic.dev/control-panel/css-javascript) for the Control Panel.
:::

### The front-end

Statamic provides a `PublishContainer` component, which is the workhorse of any publish form. Most of the time, you can use it self-closed with some props, and it will render exactly what you need.

```vue
<script setup>
import { Header, PublishContainer } from '@statamic/cms/ui';

const props = defineProps({
    blueprint: Object,
    initialValues: Object,
    initialMeta: Object,
});

const values = ref(props.initialValues);
const meta = ref(props.initialMeta);
</script>

<template>
    <Header title="Edit Product" />
    
    <PublishContainer
        v-model="values"
        :blueprint="blueprint"
        :meta="meta"
    />
</template>
```

The Publish Container will render any tabs, sections and fields appropriately based on the provided `blueprint`.

You may customize the layout of the form by providing slot content.

```html
<PublishContainer>
    <Tabs />
    <!-- etc -->
</PublishContainer>
```

Please see our [UI Component docs](https://statamic.dev/?path=/docs/components-publishcontainer--docs&args=icon:hr) for full information on the available props and events.


### Handling the form submission

The `SavePipeline` pairs with a `PublishContainer` to save your data, render any validation errors, fire hooks, etc. 

The data from your Publish Container will be sent `through` the steps. The only required step is the `Request`.

You provide the pipeline class with a reference to the Publish Container, the saving state, and errors, and it will update them for you appropriately. 

You may provide additional steps, such as the `AfterSaveHooks` here.

Once everything is done, the `then` callback will be run, like a promise. 

Any errors can be caught in the `catch` callback. If the pipeline is intentionally stopped, `e` will be an instance of `PipelineStopped`.

```vue
<script setup>
import { Header, PublishContainer } from '@statamic/cms/ui';
import { Pipeline, BeforeSaveHooks, Request, AfterSaveHooks } from '@statamic/cms/save-pipeline'; // [tl! add]
import { ref, useTemplateRef } from 'vue'; // [tl! add]

defineProps({
	blueprint: Object,
	initialValues: Object,
	initialMeta: Object,
});

const values = ref(props.initialValues);
const meta = ref(props.initialMeta);
const saving = ref(false); // [tl! add:2]
const errors = ref({});
const container = useTemplateRef('container');

function save() { // [tl! add:14]
    new Pipeline()
        .provide({ container, errors, saving })
        .through([
	        new BeforeSaveHooks('product'),
            new Request('/cp/products/{product}', 'PATCH'),
            new AfterSaveHooks('product'),
        ])
        .then((response) => {
            //
        })
        .catch((e) => {
            //
        });
}
</script>

<template>
	<Header title="Edit Product">
	    <Button text="Save" variant="primary" :disabled="saving" @click="save" /> <!-- [tl! add] -->
	</Header>
	<!-- [tl! add:2,1] [tl! add:6,1] -->
	<PublishContainer
		ref="container"
		v-model="values"
		:blueprint="blueprint"
		:meta="meta"
        :errors="errors"
	/>
</template>
```

In your controller, you'll need to get the blueprint, validate the values and process them before updating your model.

```php
use App\Models\Product;
use Illuminate\Http\Request;

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

You've just rendered an item in a Publish Form and handled updating it! Give yourself a pat on the back. 👏

:::tip
Since the values are being processed through the blueprint's fieldtypes, their values will be saved in such a way that you may need augmentation to use them.

For instance, the assets fieldtype will save an array of paths relative to the configured asset container, and when augmented will return an array of Asset objects. So, you may want to make sure that when you retrieve your data later, that it's [augmented](/extending/augmentation).
:::

## Blueprints

In the examples above, we just said "get a blueprint" but didn't tell you _how_ to get a blueprint. There's a couple ways to do it:

### Get an actual user defined blueprint

Get one from where all the blueprints are typically stored, by its handle. If it doesn't exist, it'll return `null`.

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
