---
id: afd9fcd1-e9b3-41f4-b4a9-1bec95cd5f2e
blueprint: page
title: 'Build a Form Fieldtype'
template: page
intro: "Form fieldtypes adapt Statamic's fieldtypes for collecting input from visitors. When the built-in options don't quite fit, build your own and make it feel right at home in the Form Builder."
related_entries:
  - 83786f60-def6-11e9-aaef-0800200c9a66
  - fdb45b84-3568-437d-84f7-e3c93b6da3e6
  - ecf1c18e-cdc6-4120-b19a-af1c3851ea53
---

Each form fieldtype wraps a regular [fieldtype](/fieldtypes/build-a-fieldtype) and tailors it for use in forms.

You can build your own by creating a class in the `app/FormFieldtypes` directory that extends `Statamic\Forms\Fields\FormFieldtype`. Statamic will discover it automatically.

In an addon, form fieldtypes in your addon's `src/FormFieldtypes` directory are discovered automatically too. Or you can list them in your service provider's `$formFieldtypes` property.

```php
<?php

namespace App\FormFieldtypes;

use Statamic\Forms\Fields\FormFieldtype;

class RangeSlider extends FormFieldtype
{
    protected static $fieldtype = 'range';
    protected $categories = ['rate'];
    protected $description = 'A slider for picking a number within a range.';
    protected $icon = 'fieldtype-range';

    public function configFieldItems(): array
    {
        return [
            'min' => ['display' => 'Minimum', 'type' => 'integer'],
            'max' => ['display' => 'Maximum', 'type' => 'integer'],
        ];
    }

    public function toFieldArray(): array
    {
        return [
            'type' => 'range',
            'min' => $this->config('min'),
            'max' => $this->config('max'),
        ];
    }

    public function example(): ?array
    {
        return [
            'config' => [
                'display' => 'How confident are you about your answer?',
                'min' => 1,
                'max' => 5,
            ],
            'value' => 3,
        ];
    }
}
```

## Properties

| Property | Description |
| --- | --- |
| `$fieldtype` | The handle of the regular fieldtype this form fieldtype wraps. Static. |
| `$title` | The name shown in the Form Builder. Defaults to a humanized version of the handle. Static. |
| `$description` | A short description shown in the Form Builder. |
| `$categories` | The categories the fieldtype is grouped under in the Form Builder. Should be an array. |
| `$icon` | The icon shown in the Form Builder. |
| `$order` | Controls the fieldtype's position within its category. |
| `$keywords` | Extra search terms for finding the fieldtype in the Form Builder. Should be an array. |
| `$configFields` | The configuration fields shown when editing the field. An alternative to overriding `configFieldItems()`. |
| `$selectable` | Whether the fieldtype can be picked in the Form Builder. Defaults to `true`. |
| `$collectsValue` | Whether the field collects a value from visitors. Set it to `false` for fieldtypes that only display content, so they aren't offered anywhere a submitted value is expected, like email mentions, connections, conditional logic and form summaries. Defaults to `true`. |

## Methods

| Method | Description |
| --- | --- |
| `configFieldItems()` | The configuration fields shown when editing the field in the Form Builder. |
| `toFieldArray()` | Translates the form fieldtype's config into a regular field definition. |
| `example()` | An example configuration used to preview the field in the Form Builder. Optional. |
| `prepareFrontEndRenderable(array $data)` | Adjusts the field's data before it's passed to the front-end view, and returns it. Optional. |
| `valueType()` | The shape of the values the field stores, as a `Statamic\Forms\Fields\FormValueType` case. Used by [Forms Pro](/frontend/forms-pro#charting-your-own-fieldtypes) to decide which charts and insights apply. Optional. |
| `view()` | The front-end view used to render the field. Optional. |

### Front-end views

By default, `view()` uses the first of these views that exists:

1. A view named after the wrapped fieldtype's handle, like `text`.
2. A view named after the form fieldtype's handle, like `short_answer`.
3. The wrapped fieldtype's own view.

For the first two, a [published view](/frontend/forms#customizing-the-front-end-views) in `resources/views/vendor/statamic/forms/fields` takes priority over Statamic's built-in one. Override `view()` to return a different view name.

### Adding config fields

You can add config fields to an existing form fieldtype using the static `appendConfigFields()` and `appendConfigField()` methods, typically from a service provider's `boot` method:

```php
use Statamic\Forms\Fieldtypes\ShortAnswer;

ShortAnswer::appendConfigField('group', [
    'type' => 'text',
    'display' => 'Group',
]);
```

### Sample values

Email previews and [fake submissions](/frontend/forms#generating-fake-submissions) get their values from the wrapped fieldtype's `previewValue()` and `fakeValue()` methods. If you're wrapping a custom fieldtype, see [form sample values](/fieldtypes/build-a-fieldtype#form-sample-values).

:::tip
When [Forms Pro](/frontend/forms-pro) is installed, form fieldtypes can also opt into [form summaries](/frontend/forms-pro#charting-your-own-fieldtypes) with a default chart, chart options, and insights.
:::
