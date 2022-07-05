---
id: bbea4454-efa2-4372-842b-b295376230f7
blueprint: repositories
title: 'Form Repository'
nav_title: Forms
related_entries:
  - e7833062-e05c-42c9-ad35-dc5077f1f0b8
  - acee879a-c832-449d-a714-c57ea5862717
  - 9c6a0b01-449e-49dd-8fa6-11b975d2726d
  - 7202c698-942a-4dc0-b006-b982784efb03
---
To work with the Form Repository, use the following Facade:

```php
use Statamic\Facades\Form;
```

## Methods

| Methods | Description |
| ------- | ----------- |
| `all()` | Get all Forms |
| `find($handle)` | Get Form by `handle` |
| `make()` | Makes a new `Form` instance |

:::tip
The `handle` is the name of the form's YAML file.
:::

## Querying

#### Examples {.popout}

#### Get a single form by its handle

```php
Form::find('postbox');
```

#### Get all forms from your site

```php
Form::all()
```

#### Get submissions to a form by its handle

```php
Form::find('postbox')->submissions;
```

#### Get a single submission to a form by its id

```php
Form::find('postbox')->submission($id);
```

#### Get the blueprint of a form

```php
Form::find('postbox')->blueprint();
```


## Creating

Start by making an instance of a form with the `make` method.
You need at least a handle before you can save a form.

```php
$form = Form::make()->handle('feedback');
```

You may call additional methods on the entry to customize it further.

```php
$form
  ->handle('postbox')
  ->honeypot('winnie-the-pooh')
  ->title('The Hundred Acre Wood');
```

Finally, save it. It'll return a boolean for whether it succeeded.

```php
$form->save(); // true or false
```
