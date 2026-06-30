---
id: 02261135-24fa-4d2f-9bc5-a7d2f5e6a975
blueprint: resource_apis
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

#### Get partial form submissions

```php
FormSubmission::query()
    ->where('form', 'postbox')
    ->where('partial', true)
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

## Partial Submissions

A partial submission is an incomplete submission that's been saved before the user has finished filling out the form.

They're primarily used by the [Forms Pro](/forms#forms-pro) addon to persist progress between the pages of a multi-page form, but addons and custom code can use them too.

To mark a submission as partial, call `asPartial()` before saving:

```php
$submission = FormSubmission::make()->form($form);

$submission->data(['name' => 'David Hasselhoff']);

$submission->asPartial()->save();
```

You can check whether a submission is partial using `isPartial()`, or by getting its `status()` (which either returns `partial` or `finalized`):

```php
$submission->isPartial(); // true
$submission->status(); // "partial"
```

Partial submissions are [automatically deleted](/scheduling#deletepartialformsubmissions) after a configurable number of days (7 by default).

:::tip
The `SubmissionCreating`, `SubmissionCreated`, `SubmissionSaving` and `SubmissionSaved` events are dispatched when creating partial submissions, just like any other submission.

If you're listening to these events in your code, and you _don't_ want to receive incomplete submissions, you should listen to either the [`FormSubmitted`](/events#formsubmitted) or [`SubmissionFinalized`](/events#submissionfinalized) events.
:::

### Finalizing

When a submission is complete, call `finalize()` on it. This removes its partial status, deletes it (if storage is disabled for the form), triggers the relevent connections, and dispatches the [`SubmissionFinalized`](/events#submissionfinalized) event.

```php
$submission->finalize();
```
