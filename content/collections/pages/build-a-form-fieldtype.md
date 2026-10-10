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
| `$fieldtype` | The handle of the regular fieldtype this form fieldtype wraps. |
| `$description` | A short description shown in the Form Builder. |
| `$categories` | The categories the fieldtype is grouped under in the Form Builder. Should be an array. |
| `$icon` | The icon shown in the Form Builder. |
| `$order` | Controls the fieldtype's position within its category. |

## Methods

| Method | Description |
| --- | --- |
| `configFieldItems()` | The configuration fields shown when editing the field in the Form Builder. |
| `toFieldArray()` | Translates the form fieldtype's config into a regular field definition. |
| `example()` | An example configuration used to preview the field in the Form Builder. Optional. |
| `view()` | The front-end view used to render the field. Optional. |

:::tip
When [Forms Pro](/frontend/forms-pro) is installed, form fieldtypes can also opt into [form summaries](/frontend/forms-pro#charting-your-own-fieldtypes) with a default chart, chart options, and insights.
:::
