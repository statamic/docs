---
id: fdb45b84-3568-437d-84f7-e3c93b6da3e6
blueprint: page
title: Forms
template: page
intro: 'Forms are a natural part of the internet experience and a core component of most websites. From a basic "Contact Me" form to a multi-page job application, Statamic can help manage your forms, submissions, and thereby make your life a little bit easier.'
related_entries:
  - e4f4f91e-a442-4e15-9e16-3b9880a25522
---
## Overview

Statamic forms collect submissions, provide reports on them on aggregate, and display user submitted data on the [frontend](/frontend). The end-to-end solution includes tags, settings, and a dedicated area of the Control Panel.

## Your first form

Let's pretend you're a famous celebrity with a large following of dedicated fans. If this is true, why are you building your own website? Who's going to sail your yacht?

Okay, let's just pretend you're a famous celebrity's _web developer_. You've been tasked with collecting electronic fan mail (we'll call it EF-Mail). You want to collect the following bits of info from <del>crazed</del> enthusiastic fans:

- name
- age
- level of adoration
- message

### Create the form

First, head to `/cp/forms` in the Tools area of the Control Panel and click the **Create Form** button. Alternately you can create a `.yaml` file in `resources/forms` which will contain all the form's settings.

Each form should contain a title.

```yaml
title: Super Fans
```

### Add your fields

With your form created, you can start adding fields using the **Form Builder** in the Control Panel. Each field you add is a [form fieldtype](#form-fieldtypes) — like a short answer, dropdown, or file upload — and you can configure its display name, validation rules, and [logic](/conditional-fields) without leaving the Control Panel.

For our EF-Mail form, you'd add a Name field for the name, a Number for the age, a Star Rating for the level of adoration, and a Long Answer for the message.

### The template

Several [tags](/tags/form) are provided to help you manage your form. You can explore these at your leisure, but for now here's a look at a basic form template.

This example loops over your form's fields and dynamically renders each input's HTML, so you don't need to hardcode field handles. You could alternatively write the HTML yourself, perform conditions on the field's `type`, or even [customize the automatic HTML](/tags/form-create#pre-rendered-field-html).

::tabs

::tab antlers
```antlers
{{ form:super_fans }}

    // First let's check if this is after a submission, and if so, was it successful.
    // If it was, just show the success message. After all, we don't want them submitting again once they've gotten in touch!
    {{ if success }}
        <div class="bg-green-300 text-white p-2">
            {{ success }}
        </div>
    {{ else }}
        // If we weren't successful, show any errors. If a fresh page load, there's no errors, so do nothing.
        {{ if errors }}
            <div class="bg-red-300 text-white p-2">
                {{ errors }}
                    {{ value }}<br>
                {{ /errors }}
            </div>
        {{ /if }}

        // Loop through and render the form inputs
        {{ fields }}
            <div class="p-2">
                <label>{{ display }}</label>
                <div class="p-1">{{ field }}</div>
                {{ if error }}
                    <p class="text-gray-500">{{ error }}</p>
                {{ /if }}
            </div>
        {{ /fields }}

        // Add the honeypot field
        <input type="text" class="hidden" name="{{ honeypot ?? 'honeypot' }}">

        // This is just a submit button.
        <button type="submit">Submit</button>
    {{ /if }}

{{ /form:super_fans }}
```
::tab blade
```blade
<s:form:super_fans>

  // First let's check if this is after a submission, and if so, was it successful.
  // If it was, just show the success message. After all, we don't want them submitting again once they've gotten in touch!
  @if ($success)
    <div class="bg-green-300 text-white p-2">
      {{ $success }}
    </div>
  @else
    // If we weren't successful, show any errors. If a fresh page load, there's no errors, so do nothing.
    @if (count($errors) > 0)
      <div class="bg-red-300 text-white p-2">
        @foreach ($errors as $error)
          {{ $error }}<br>
        @endforeach
      </div>
    @endif

    // Loop through and render the form inputs
    @foreach ($fields as $field)
      <div class="p-2">
        <label>{{ $field['display'] }}</label>
        <div class="p-1">{!! $field['field'] !!}</div>
        @if ($field['error'])
          <p class="text-gray-500">{{ $field['error'] }}</p>
        @endif
      </div>
    @endforeach

    // Add the honeypot field
    <input type="text" class="hidden" name="{{ isset($honeypot) ? $honeypot : 'honeypot' }}" />

    // This is just a submit button.
    <button type="submit">Submit</button>
  @endif

</s:form:super_fans>
```
::

## Form fieldtypes

When building a form, you add fields using **form fieldtypes**. These are purpose-built versions of Statamic's [fieldtypes](/fieldtypes), designed specifically for collecting input from your visitors and rendering on the front-end. Each one comes with a corresponding front-end view, so it's ready to drop into your templates.

The following form fieldtypes are available:

| Fieldtype | Description |
|---|---|
| Group | Group related fields together. |
| Spacer | Add visual spacing between form fields. |
| Heading | A heading to organize your form. |
| Paragraph | A paragraph to provide information in your form. |
| Banner | A banner to highlight important information in your form. |
| Short Answer | A simple field for short, one-line answers. |
| Long Answer | A larger field for detailed responses, comments, or messages. |
| Dropdown | A dropdown list where respondents pick from your options. |
| Yes / No | A simple yes or no question. |
| Multiple Choice | A question with a range of answer options. Respondents can only choose one answer. |
| Checkboxes | Respondents can select multiple options from a list. |
| Image Choice | An image-based choice selector for visual options. |
| Toggle | A simple yes or no switch. |
| Dictionary | Select from a predefined list like countries, timezones, or currencies. |
| Opinion Scale | An opinion scale for measuring agreement or satisfaction. |
| Star Rating | A star rating input for collecting ratings. |
| Ranking | A ranking input for ordering items by preference. |
| Name | Collects someone's name. |
| Email | Collects an email address and ensures it's properly formatted. |
| Website | Collects a website address and ensures it's properly formatted. |
| Phone | A field for collecting phone numbers. |
| Number | Collects a number. You can set minimum and maximum values. |
| Currency | Collects a monetary amount. |
| Date Picker | Lets respondents pick a date. |
| Time Picker | Lets respondents pick a time of day. |
| Upload | Lets respondents upload one or more files. See [File uploads](#file-uploads). |

:::tip
Click a fieldtype in the Form Builder to see an example of what it looks like.
:::

### Customizing the front-end views

Each form fieldtype renders using a publishable view. To customize the HTML, run `php artisan vendor:publish --tag=statamic-forms`, which exposes editable templates in your `resources/views/vendor/statamic/forms/fields` directory.

:::tip
Publishable views are implemented in Antlers by default. Blade versions will be used instead if your `statamic.templates.language` config is set to `blade`.
:::

### Controlling which fieldtypes are selectable

Most form fieldtypes are selectable in the Form Builder by default. You can change this from a service provider by calling `makeSelectable()` or `makeUnselectable()` on the relevant fieldtype class:

```php
use Statamic\Forms\Fieldtypes\Dictionary;

public function boot()
{
    Dictionary::makeUnselectable();
}
```

### Building a custom form fieldtype

Each form fieldtype wraps a regular [fieldtype](/fieldtypes) and tailors it for use in forms.

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

#### Properties

| Property | Description |
| --- | --- |
| `$fieldtype` | The handle of the regular fieldtype this form fieldtype wraps. |
| `$description` | A short description shown in the Form Builder. |
| `$categories` | The categories the fieldtype is grouped under in the Form Builder. Should be an array. |
| `$icon` | The icon shown in the Form Builder. |
| `$order` | Controls the fieldtype's position within its category. |

#### Methods

| Method | Description |
| --- | --- |
| `configFieldItems()` | The configuration fields shown when editing the field in the Form Builder. |
| `toFieldArray()` | Translates the form fieldtype's config into a regular field definition. |
| `example()` | An example configuration used to preview the field in the Form Builder. Optional. |
| `view()` | The front-end view used to render the field. Optional. |

## Viewing submissions

In the Forms area of the Control Panel you can explore the collected responses and export the data to CSV or JSON formats.

<figure>
  <img src="/img/cp-forms.webp" alt="List of form submissions in the control panel" class="u-hide-in-dark-mode">
  <img src="/img/cp-forms-dark.webp" alt="List of form submissions in the control panel" class="u-hide-in-light-mode">
  <figcaption>Forms. Submissions. Features.</figcaption>
</figure>

When running a [multi-site](/multi-site), you'll only see submissions submitted from the current site. You may remove the filter to see submissions from all sites you have access to.

### Generating fake submissions

To help test how your submissions display on the front-end with the [form submissions](/tags/form-submissions) tag, you can generate fake submissions populated with realistic data. From the submissions listing, use the **Generate Fake Submission** button:

- **Generate Fake Submission** creates a submission directly, without firing events or sending [connections](#connections).
- **Generate Fake Submission + Run All Workflows** runs the submission through the full pipeline, firing events and sending any configured [connections](#connections) — handy for testing those too.

Fake submissions are flagged so you can tell them apart and bulk-delete them when you're done. If you'd like to disable fake submission generation for a form, you can turn it off in the form's settings.

## Displaying submission data

You can display any or all of the submissions of your forms on the front-end of your site using the [form submissions][submissions] Tag.

::tabs

::tab antlers
```antlers
<h2>My fans have said some things you can't forget...</h2>
{{ form:submissions in="superfans" }}
  {{ message | markdown }}
{{ /form:submissions }}
```
::tab blade
```blade
<h2>My fans have said some things you can't forget...</h2>
<s:form:submissions in="superfans">
  {!! Statamic::modify($message)->markdown() !!}
</s:form:submissions>
```
::

## Exporting your data

Exporting your data is just a click of the **Export** button away. You have the choice between CSV and JSON. Choose wisely, or choose both, it doesn't matter to us.

### Configuring exporters

Out of the box, Statamic gives you two exporters: a CSV exporter and a JSON exporter.

```php
// config/statamic/forms.php

'exporters' => [
    'csv' => [
        'class' => Statamic\Forms\Exporters\CsvExporter::class,
    ],
    'json' => [
        'class' => Statamic\Forms\Exporters\JsonExporter::class,
    ],
],
```

If you want to customize the labels of the exporters, you may add a `title` key to the exporter's config. You can also add a `forms` key to the exporter config to limit it to certain forms:

```php
// config/statamic/forms.php

'exporters' => [
    'csv' => [
        'class' => Statamic\Forms\Exporters\CsvExporter::class,
        'title' => 'CSV (Works in Excel)',
        'forms' => ['contact_form', 'event_registrations'],
    ],
],
```

### CSV Exporter

The CSV exporter supports two configuration options:

#### `csv_delimiter`

This allows you to configure the delimiter used for CSV exports. This defaults to `,`.

```php
// config/statamic/forms.php

'csv_delimiter' => ',',
```

#### `csv_headers`

This allows you to configure whether the field handle or the field display text is used for the CSV's heading row. This defaults to `handle`.

```php
// config/statamic/forms.php

'csv_headers' => 'handle',
```

### Custom exporter

If you need to export form submissions in a different file format or need more flexibility around how the CSV/JSON files are created, you may build your own custom exporter.

To build a custom exporter, simply create a class which extends Statamic's `Exporter` class and implement the `export` and `extension` methods:

```php
<?php

namespace App\Forms\Exporters;

use Statamic\Forms\Exporters\Exporter;

class SpecialExporter extends Exporter
{
    public function export(): string
    {
        return '';
    }

    public function extension(): string
    {
        return 'csv';
    }
}
```

The `export` method should return the file contents and the `extension` method should return the file extension.

Then, to make the exporter available on your forms, simply add it to your forms config:

```php
// config/statamic/forms.php

'exporters' => [
    'csv' => [
        'class' => Statamic\Forms\Exporters\CsvExporter::class,
    ],
    'json' => [
        'class' => Statamic\Forms\Exporters\JsonExporter::class,
    ],
    'special_exporter' => [ // [tl! focus]
        'class' => App\Forms\Exporters\SpecialExporter::class, // [tl! focus]
    ], // [tl! focus]
],
```

## Connections

Out of the box, you'll only know about a submission when you head into the Control Panel to view it. Most of the time you'll want something to happen when a form is submitted — like being notified by email.

**Connections** let you send submissions off to other places. Statamic ships with an Email connection out of the box, and more will be added over time.

### Email

The Email connection sends an email whenever a form is submitted. You can add any number of emails to your form.

```yaml
email:
  -
    to: hello@celebrity.com
    from: website@celebrity.com
    subject: You've got fan mail!
    html: fan-mail
    text: fan-mail-text
  -
    to: agent@celebrity.com
    subject: Someone still likes your client
```

Here we'll send two emails for every submission of this form. One will go to the celebrity, and one to the agent. The first one uses custom html and text views while the other doesn't, so it'll get an "automagic" email. The automagic email will be a simple text email with a list of all fields and values in the submission.

#### Email variables

Inside your email view, you have a number of variables available:

- `date`, `now`, `today` - The current date/time
- `site_url` - The site home page.
- `site`, `locale` - The handle of the site
- `config` - Any app configuration values
- `email_config` - The email's config (the current item from your `email:` array)
- `form_config` - Any extra config values appended to the form's blueprint (e.g. via addons using `Form::appendBlueprintTab()`)
- Any data from [Global Sets](/globals#global-sets)
- All of the submitted form values
- A `fields` array

The submitted form values will be augmented for you. For instance, if you have an `assets` field, you will get a collection of Asset objects rather than just an array of paths. Or, a `select` field will be an array with `label` and `value` rather than just the value.

::tabs

::tab antlers
```antlers
<b>Name:</b> {{ name }}
<b>Email:</b> {{ email }}
```
::tab blade
```blade
<b>Name:</b> {{ $name }}
<b>Email:</b> {{ $email }}
```
::

The `fields` variable is an array available for you for if you'd rather loop over your values in a dynamic way:

::tabs

::tab antlers
```antlers
{{ fields }}
    <b>{{ display }}</b> {{ value }}
{{ /fields }}
```
::tab blade
```blade
@foreach ($fields as $field)
  <b>{{ $field['display'] }}</b> {{ $field['value'] }}
@endforeach
```
::

In each iteration of the `fields` array, you have access to:

- `display` - The display name of the field. (e.g. "Name")
- `handle` - The handle of the field (e.g. "name")
- `value` - The augmented value (same as explained above)
- `fieldtype` - The handle of the fieldtype (e.g. "assets")
- `config` - The configuration of the blueprint field


#### Setting the from and reply-to name

You can set a full "From" and "Reply-To" name in addition to the email address using the following syntax:

```
from: 'Jack Black <jack@jackblack.com>'
reply_to: 'Jack Black <jack@jackblack.com>'
```


#### Setting the recipient dynamically

You can set the recipient to an address submitted in the form by using the variable in your config block. Assuming you have a form input with `name="email"`:

```yaml
email:
  -
    to: "{{ email }}"
    # other settings here
```

#### Setting the "Reply to" dynamically

You can set the "reply to" to an address submitted in the form by using the variable in your config block. Assuming you have a form input with `name="email"`:

```yaml
email:
  -
    reply_to: "{{ email }}"
    # other settings here
```

#### Setting the "Subject" dynamically

You can set the email "subject" to a value in your form by using the variable in your config block. Assuming you have a form input with `name="subject"`:

```yaml
email:
  -
    subject: '{{ subject ?? "Email Form Submission" }}'
    # other settings here
```

[Learn how to create your emails](/email)

#### Attachments

When using [file uploads](#file-uploads) in your form, you may choose to have those attached to the email. By adding `attachments: true` to the email config, any uploaded files will be automatically attached.

```yaml
email:
  -
    attachments: true
    # other settings here
```

If you don't want the attachments to be kept around on your server, configure your [Upload field](#file-uploads) so it doesn't store the files — they'll be attached to the email and then deleted.

#### Using Markdown Mailable Templates

Laravel allows you to create email templates [using Markdown](https://laravel.com/docs/mail#markdown-mailables). It's pretty simple to wire these up with your form emails:

1. Enable Markdown parsing in your email config:

```yaml
email:
  -
    # other settings here
    markdown: true # [tl! add]
```

2. Next, create a **Blade** view for your email template and start using Laravel's Markdown Mailable components:

```yaml
email:
  -
    # other settings here
    markdown: true
    html: 'contact-us' # [tl! add]
```

```blade
{{-- contact-us.blade.php --}}
<x-mail::message>
# New form submission

Someone has taken the time to fill out a form on your website. Here are the details:

<x-mail::panel>
@foreach ($fields as $item)
<strong>{{ $item['display'] }}:</strong> {{ $item['value'] }}<br>
@endforeach
</x-mail::panel>
</x-mail::message>
```

:::warning
Make sure you don't use indentation in your Markdown view. Laravel's markdown parser will render it as code.
:::

You can customize the components further by reviewing the [Laravel documentation](https://laravel.com/docs/13.x/mail#customizing-the-components).

## File uploads

Maybe your fans want to send a photo, or you're collecting resumes and cover letters. Whatever the files, add an **Upload** field to your form and you're collecting them.

When configuring the Upload field, you decide whether the uploaded files should be kept around:

- **Store the files** and they'll be permanently saved as reusable [Assets](/assets) in the asset container you choose.
- **Don't store the files** and they'll only stick around long enough to be sent with your form's [connections](#connections) (like email attachments), then they'll be deleted shortly after the form is submitted.

You can also set a maximum number of files to control whether respondents can upload a single file or several.

## Honeypot

Simple and effective spam prevention.

The honeypot technique is simple. Add a field to your forms, that when filled in will cause the submission to fail, but appear successful. Nothing will be saved and no emails are sent.

Hide this field by a method of your choosing (ie. CSS), so your users won't see it but spam bots will just think it’s another field.

For example:

::tabs

::tab antlers
```antlers
{{ form:create }}
    ...
    <input type="text" name="honeypot" class="honeypot" />
{{ /form:create }}
```
::tab blade
```blade
<s:form:create>
  ...
  <input type="text" name="honeypot" class="honeypot" />
</s:form:create>
```
::

```css
.honeypot { display: none; }
```

:::tip
In order to fool smarter spam bots, you should customize the name of the field by changing the `name=""` attribute to something common, but not used by your particular form. Like `username` or `address`. Then, add `honeypot: your_field_name` to your form's config.
:::

## Rate limiting

Form submissions are rate limited by IP address to help protect against abuse. By default, the `statamic.forms` limiter allows 10 submissions per minute across all forms.

You can customize the limit by redefining the named rate limiter in your `AppServiceProvider`'s `boot` method:

```php
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

public function boot()
{
    RateLimiter::for('statamic.forms', function (Request $request) {
        return Limit::perMinute(20)->by($request->ip());
    });
}
```

Consult the [Laravel documentation](https://laravel.com/docs/13.x/routing#rate-limiting) to learn more about defining rate limiters.

## Submitting forms programmatically

The [`form:create`](/tags/form-create) tag handles submissions for you, but you can also submit a form yourself using the `SubmitForm` action. This makes it easy to submit forms from a Livewire component, a custom controller, or your own API endpoint.

```php
use Statamic\Facades\Form;
use Statamic\Forms\SubmitForm;
use Statamic\Exceptions\SilentFormFailureException;
use Illuminate\Validation\ValidationException;

$form = Form::find('contact');

try {
    $submission = app(SubmitForm::class)
        ->form($form)
        ->submit(
            data: ['name' => 'John', 'email' => 'john@example.com'],
            files: [], // Optional
        );
} catch (ValidationException $e) {
    return back()->withErrors($e->errors());
} catch (SilentFormFailureException $e) {
    // The honeypot was triggered, or an event listener rejected the
    // submission. To the user, it should appear as though it succeeded.
    return back()->with('success', 'Form submitted successfully!');
}

return back()->with('success', 'Form submitted successfully!');
```

The action provides the following methods:

| Method | Description |
| --- | --- |
| `form` | Provide the `Form` you want to use. |
| `page` | Optional. (intended to be used alongside Forms Pro's multi-page forms feature) ID of the page you want to submit. |
| `resume` | `Submission` instance of the partial submission you wish to resume. |
| `submit` | Submit the form. Accepts an array of `$data` and an optional array of `$files`. Returns a `SubmissionResult` object containing the submission and the ID of the next page (in the case of a multi-page form). |
| `validate` | Validate the current page. Accepts an array of `$data` and an optional array of `$files`. Also accepts an array of field handles to limit which fields are validated. |

:::tip
When the [honeypot](#honeypot) catches spam — or an event listener returns `false` from the [`FormSubmitted`](/events#formsubmitted) event — a `SilentFormFailureException` is thrown rather than a validation error, so spam bots still see a success response. The submission data is available via `$e->submission()`.
:::

## Forms Pro

Need more from your forms? [Forms Pro](https://statamic.com/addons/statamic/forms-pro) is a paid addon that builds on Statamic's built-in forms with features like:

- Multi-page forms
  - Control page logic in a list or edit rules in a tree view
- Dedicated form pages
- Unique form instances per entry
- Additional fieldtypes & connections
- Enhanced spam prevention

### Multi-page forms

When it comes to creating form logic, you can already show and hide fields based on a user's previous responses. Forms Pro supercharges this by introducing **multi-page forms**.

This is especially useful for longer forms. Breaking them into pages makes them easier to complete, and gives you greater control over the user journey—skipping entire sections or guiding users down different paths based on their answers.

<figure>
  <img src="/img/forms-pro/page-logic.webp" alt="Page logic for Forms Pro in the control panel" class="u-hide-in-dark-mode">
  <img src="/img/forms-pro/page-logic-dark.webp" alt="Page logic for Forms Pro in the control panel" class="u-hide-in-light-mode">
  <figcaption>With Forms Pro you get Page logic as well as field logic</figcaption>
</figure>

#### Customize page buttons

Page buttons default to “Next” and “Previous” but you can customize them to say whatever you want. Tease your users with something informative or cheeky—“Let's find out what Star Sign you are!”, “Ready to find out your perfect career?”, “Which Ninja Turtle are you?”, etc.

<figure>
  <img src="/img/forms-pro/customize-button-text.webp" alt="Customize button text for Forms Pro" class="u-hide-in-dark-mode">
  <img src="/img/forms-pro/customize-button-text-dark.webp" alt="Customize button text for Forms Pro" class="u-hide-in-light-mode">
  <figcaption>Customize button text for Forms Pro</figcaption>
</figure>

### Dedicated form pages

Learn more about Forms Pro [on the Statamic Marketplace](https://statamic.com/addons/statamic/forms-pro).

[submissions]: /tags/form-submissions
