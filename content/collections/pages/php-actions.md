---
id: aea5645d-cffa-4029-b04e-58efcd4303e4
blueprint: page
title: Actions
intro: Actions are classes that perform discrete tasks outside of the HTTP request lifecycle, making them reusable across controllers, console commands, Livewire components, and more.
related_entries:
  - bbea4454-efa2-4372-842b-b295376230f7
  - 02261135-24fa-4d2f-9bc5-a7d2f5e6a975
---

## Overview {#overview}

Actions are classes that perform specific tasks, like submitting a form.

Since they're not tied to a controller or the request lifecycle, you can use them anywhere: console commands, API endpoints, Livewire components — wherever you need them.

## Available Actions

### SubmitForm

The `SubmitForm` action handles form submission, including file uploads, honeypot validation, event dispatching and sending emails.

```php
use Statamic\Facades\Form;
use Statamic\Facades\Site;
use Statamic\Forms\SubmitForm;
use Statamic\Exceptions\SilentFormFailureException;
use Illuminate\Validation\ValidationException;

$form = Form::find('contact');

try {
    $submission = app(SubmitForm::class)->submit(
        form: $form,
        data: ['name' => 'John', 'email' => 'john@example.com'],
        files: [], // Optional
        site: Site::current(), // Optional
    );
} catch (ValidationException $e) {
    return back()->withErrors($e->errors());
} catch (SilentFormFailureException $e) {
    // Honeypot triggered or event listener rejected
    // $e->submission() contains the submission data

    return back()->with('success', 'Form submitted successfully!');
}

return back()->with('success', 'Form submitted successfully!');
```

#### Validation

The `->submit()` method validates inputs automatically before saving. If you'd prefer to handle validation yourself, you may call the `->validator()` method which returns a Laravel `Validator` instance:

```php
app(SubmitForm::class)->validator($form, $data);
```

#### Exceptions

The action may throw a `SilentFormFailureException` when the honeypot is triggered or a `FormSubmitted` event listener returns `false`. This exception contains the submission via `$e->submission()`.

When handling this exception, you should return a fake success response to avoid tipping off bots.

#### Arguments

| Argument | Type | Description |
|----------|------|-------------|
| `form` | `Form` | The form to submit to. |
| `data` | `array` | The submission data. |
| `files` | `array` | Uploaded files, keyed by field handle. Defaults to `[]`. |
| `site` | `Site` | The site context, used for email localization. Defaults to `Site::default()`. |
