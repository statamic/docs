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
| `all()` | Get all form submissions, including partial and spam submissions. |
| `whereForm($handle)` | Get submissions by form handle, including partial and spam submissions. |
| `whereInForm($handles)` | Get submissions, across multiple forms. Accepts an array of form handles. |
| `find($id)` | Get a form submission, by its submission ID. |
| `make()` | Makes a new `Submission` instance |
| `query()` | Query Builder |

:::tip
These methods return submissions of every [status](#partial-submissions). `$form->submissions()` and the form's submission count only include finalized submissions. Use `$form->querySubmissions()` if you need the others.
:::

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

#### Get form submissions by status

```php
FormSubmission::query()
    ->where('form', 'postbox')
    ->whereStatus('partial') // or 'finalized', 'spam' or 'any'
    ->get();
```

:::tip
`whereStatus()` is available on the default (Stache) submission query builder, but isn't part of the query builder contract, so custom drivers may not support it. Partial submissions have a `_partial` key set to `true`, and spam submissions have a `_marked_spam_at` timestamp, so you can query those directly instead.
:::


## Creating

Start by making an instance of a form submission with the `make` method.
You need to pass in [a `Form` instance](/backend-apis/resource-apis/form-repository) before you can save a form submission.

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

They're primarily used by the [Forms Pro](/frontend/forms-pro) add-on to persist progress between the pages of a multi-page form, but add-ons and custom code can use them too.

To mark a submission as partial, call `asPartial()` before saving:

```php
$submission = FormSubmission::make()->form($form);

$submission->data(['name' => 'David Hasselhoff']);

$submission->asPartial()->save();
```

You can check whether a submission is partial using `isPartial()`, or by getting its `status()` (which returns `partial`, `finalized` or `spam`):

```php
$submission->isPartial(); // true
$submission->status(); // "partial"
```

Partial submissions are [automatically deleted](/scheduling#deletepartialformsubmissions) after a configurable number of days (7 by default).

:::tip
Saving a partial submission only dispatches the [`SubmissionSaving`](/events#submissionsaving) and [`SubmissionSaved`](/events#submissionsaved) events. The [`SubmissionCreating`](/events#submissioncreating) and [`SubmissionCreated`](/events#submissioncreated) events aren't dispatched until the submission is finalized.
:::

### Finalizing

When a submission is complete, call `finalize()` on it. You don't need to call `save()` yourself. It:

1. Removes its partial status and converts any uploaded files into assets.
2. Dispatches the [`SubmissionCreating`](/events#submissioncreating) event. If a listener returns `false`, the submission isn't stored, but finalizing carries on.
3. Saves the submission, then dispatches [`SubmissionCreated`](/events#submissioncreated).
4. Dispatches [`SubmissionFinalized`](/events#submissionfinalized).
5. Triggers the form's [connections](/frontend/forms#connections).

If storage is disabled for the form, `SubmissionCreating` doesn't fire. Instead, `SubmissionCreated` fires and the partial submission is deleted, before carrying on with `SubmissionFinalized` and the connections.

Calling `finalize()` on a submission that isn't partial does nothing.

```php
$submission->finalize();
```

## Spam Submissions

A submission can be [marked as spam](/frontend/forms#spam-submissions), which hides it from the submissions listing by default and excludes it from submission counts and limits.

```php
$submission->markAsSpam()->save();

$submission->isSpam(); // true
$submission->status(); // "spam"
```

To remove the flag again, call `markAsNotSpam()`:

```php
$submission->markAsNotSpam()->save();
```

When a partial submission is marked as spam, it stops reporting itself as partial — `isPartial()` returns `false`, so it can't be resumed, and it's skipped by the automatic partial submission cleanup. Under the hood, the internal `_partial` key is kept as a record that the submission was never finalized. That way, marking it as not spam and calling `finalize()` will send the submission through the full pipeline, as if it had just been submitted:

```php
$submission->markAsNotSpam();

$submission->isPartial()
    ? $submission->finalize()
    : $submission->save();
```

If a `SubmissionCreating` listener returns `false` while a spam submission is being finalized, `finalize()` returns `false` and the submission stays marked as spam.

Spam submissions are [automatically deleted](/scheduling#deletespamformsubmissions) a configurable number of days after being marked as spam (30 by default).
