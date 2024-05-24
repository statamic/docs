---
id: 02261135-24fa-4d2f-9bc5-a7d2f5e6a975
blueprint: repositories
title: 'Form Submission Repository'
nav_title: Form Submissions
related_entries:
  - fdb45b84-3568-437d-84f7-e3c93b6da3e6
  - e4f4f91e-a442-4e15-9e16-3b9880a25522
  - bbea4454-efa2-4372-842b-b295376230f7
---
To work with the Form Submissions Repository, use the following Facade:

```php
use Statamic\Facades\FormSubmission;
```

## Methods

| Methods | Description |
| ------- | ----------- |
| `all()` | Get all form submissions. |
| `whereForm($handle)` | Get submissions by form handle. |
| `whereInForm($handles)` | Get submissions, across multiple forms. Accepts an array of form handles. |
| `find($id)` | Get a form submission, by its submission ID. |
| `make()` | Makes a new `Submission` instance |
| `query()` | Query Builder |

## Querying

#### Examples {.popout}

#### Get form submissions by form

```php
FormSubmission::whereForm('postbox');
```

#### Get form submissions, between multiple forms

```php
FormSubmission::whereInForm(['postbox', 'newsletter']);
```

#### Get a single submission to a form by its id

```php
FormSubmission::find($id);
```

#### Get form submissions, filtered by field

```php
FormSubmission::query()
    ->where('form', 'postbox')
    ->where('email', 'hoff@statamic.com')
    ->get();
```


## Creating

Start by making an instance of a form submission with the `make` method.
You need to pass in [a `Form` instance](/repositories/form-repository) before you can save a form submission.

```php
$form = \Statamic\Facades\Form::find('postbox');

$submission = FormSubmission::make()->form($form);
```

To set submission data, you may call the `->data()` method and pass an array:

```php
$submission->data([
    'name' => 'David Hasselhoff',
    'email' => 'hoff@statamic.com',
]);
```

Finally, save it. It'll return a boolean for whether it succeeded.

```php
$submission->save(); // true or false
```
