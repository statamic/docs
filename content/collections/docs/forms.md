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

## Your First Form

Let's pretend you're a famous celebrity with a large following of dedicated fans. If this is true, why are you building your own website? Who's going to sail your yacht?

Okay, let's just pretend you're a famous celebrity's _web developer_. You've been tasked with collecting electronic fan mail (we'll call it EF-Mail). You want to collect the following bits of info from <del>crazed</del> enthusiastic fans:

- name
- age
- level of adoration (appreciation, fixation, or obsession)
- message

### Create the form

First, head to `/cp/forms` in the Tools area of the Control Panel and click the **Create Form** button. Alternately you can create a `.yaml` file in `resources/forms` which will contain all the form's settings.

Each form should contain a title. Optionally it may also have an email configuration.

```yaml
title: Super Fans
email: []
```

### The Blueprint

The [blueprint](blueprints) is where you define your form's `fields` and validation rules to be used on form submission.

The blueprint is located in `resources/blueprints/forms/{handle}.yaml`

```yaml
fields:
  -
    handle: name
    field:
      display: Name
      type: text
      validate: required
  -
    handle: age
    field:
      display: Age
      type: text
      validate: required|integer
  -
    handle: adoration
    field:
      display: Level of Adoration
      type: text
      validate: required
  -
    handle: comment
    field:
      display: Comment
      type: textarea
      validate: required
```

:::warning
The `message` variable is a Laravel reserved word within this email context, so you should avoid using that as a field handle if you intend on using the email feature.
:::

If you use the Control Panel to build your blueprint, you will find that there's only a subset of fieldtypes available to you.
These are the fields that have corresponding views ready to be used on the front-end.

If you'd like to include more fieldtypes, you can opt into each one by calling `makeSelectableInForms` on the respective class within a service provider:

```php
Statamic\Fieldtypes\Section::makeSelectableInForms();
```

### The Template

Several [tags](tags/form) are provided to help you manage your form. You can explore these at your leisure, but for now here's a look at a basic form template.

This example dynamically renders each input's HTML. You could alternatively write the HTML yourself, perform conditions on the field's `type`, or even [customize the automatic HTML](/tags/form-create#dynamic-rendering).

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

## Viewing Submissions

In the Forms area of the control panel you can explore the collected responses, configure dashboards and export the data to CSV or JSON formats.

<figure>
  <img src="/img/cp-forms.png" alt="List of form submissions in the control panel">
  <figcaption>Forms. Submissions. Features.</figcaption>
</figure>

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

### Custom Exporter

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

## Emails

Allowing your fans to send their comments is all well and good, but at this point you will only know about it when you head back into the Control Panel to view the submissions. Wouldn't it be better to get notified? Let's hook that up next.

You can add any number of emails to your formset.

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

### Email variables

Inside your email view, you have a number of variables available:

- `date`, `now`, `today` - The current date/time
- `site_url` - The site home page.
- `site`, `locale` - The handle of the site
- `config` - Any app configuration values
- `email_config` - The form's config
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


### Setting the From and Reply-To Name

You can set a full "From" and "Reply-To" name in addition to the email address using the following syntax:

```
from: 'Jack Black <jack@jackblack.com>'
reply_to: 'Jack Black <jack@jackblack.com>'
```


### Setting the Recipient Dynamically

You can set the recipient to an address submitted in the form by using the variable in your config block. Assuming you have a form input with `name="email"`:

```yaml
email:
  -
    to: "{{ email }}"
    # other settings here
```

### Setting the "Reply To" Dynamically

You can set the "reply to" to an address submitted in the form by using the variable in your config block. Assuming you have a form input with `name="email"`:

```yaml
email:
  -
    reply_to: "{{ email }}"
    # other settings here
```

### Setting the "Subject" Dynamically

You can set the email "subject" to a value in your form by using the variable in your config block. Assuming you have a form input with `name="subject"`:

```yaml
email:
  -
    subject: '{{ subject ?? "Email Form Submission" }}'
    # other settings here
```

[Learn how to create your emails](/email)

### Attachments

When using [file uploads](#file-uploads) in your form, you may choose to have those attached to the email. By adding `attachments: true` to the email config, any `assets` fields will be automatically attached.

```yaml
email:
  -
    attachments: true
    # other settings here
```

If you don't want the attachments to be kept around on your server, you should pick the `files` fieldtype option explained in the [File Uploads](#file-uploads) section.

### Using Markdown Mailable Templates

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

You can customize the components further by reviewing the [Laravel documentation](https://laravel.com/docs/11.x/mail#customizing-the-components).

## File Uploads

Sometimes your fans want to show you things they've created, like scissor-cut love letters and innocent selfies with cats. No problem! File input types to the rescue. Inform Statamic you intend to collect files, specify where you'd like the uploads to go, and whether you'd like them to simply be placed in a directory somewhere, or become reusable Assets.

First, add a file upload field to your blueprint:
- Add an `assets` field if you want the uploaded files to be stored in one of your asset containers.
- Add a `files` field if you're only wanting to attach the uploads to the email. Anything uploaded using this fieldtype will be attached and then deleted after the emails are sent.

Then decide if you need single or multiple files to be uploaded.

### Single files

On your field, add a `max_files` setting of `1`:

```
<input type="file" name="cat_selfie" />
```

```yaml
fields:
  -
    handle: cat_selfie
    field:
      type: assets
      container: main
      max_files: 1
```

### Multiple files

You have two methods available to you:

First, you can create separate fields for each upload. This is useful if each has a separate purpose, like Resume, Cover Letter, and Headshot. You'll need to explicitly create each and every one in your formset.

Or, you can enable multiple files on one field by dropping the `max_files` setting on your field, and using array syntax on your input by adding a set of square brackets to the `name` attribute:

```
<input type="file" name="selfies[]" multiple />
```

```yaml
fields:
  -
    handle: selfies
    field:
      type: assets
      container: main
```

## Honeypot

Simple and effective spam prevention.

The honeypot technique is simple. Add a field to your forms, that when filled in will cause the submission to fail, but appear successful. Nothing will be saved and no emails are sent.

Hide this field by a method of your choosing (i.e. CSS), so your users won't see it but spam bots will just think it’s another field.

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
In order to fool smarter spam bots, you should customize the name of the field by changing the `name=""` attribute to something common, but not used by your particular form. Like `username` or `address`. Then, add `honeypot: your_field_name` to your formset config.
:::

## Using AJAX

To submit the form with AJAX, be sure to pass all the form inputs in with the submission, as Statamic sets `_token` and `_params`, both of which are required.

You'll also need to set your ajax library's `X-Requested-With` header to `XMLHttpRequest`.

## Caching

If you are static caching the URL containing a form, return responses like 'success' and 'errors' will not be available after submitting unless you [exclude this page from caching](/static-caching#excluding-pages) or wrap the form in {{ nocache }} tags.

**Wrapping the form in {{ nocache }}**

::tabs

::tab antlers
```antlers
{{ nocache }}
    {{ form:create formset="contact" }}
        ...
    {{ /form:create }}
{{ /nocache }}
```
::tab blade
```blade
<s:nocache>
  <s:form:create formset="contact">
    ...
  </s:form:create>
</s:nocache>
```
::

### Axios Example

``` javascript
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
form = document.getElementById('form');

// On submit...
axios.post(form.action, new FormData(form))
  .then(response => {
      console.log(response.data)
  });
```

## Precognition
Statamic supports using [Laravel Precognition](https://laravel.com/docs/11.x/precognition) in forms.

Here is a basic example that uses Alpine.js for the Precognition validation, and a regular form submission. This is a starting point that you may customize as needed. For instance, you might prefer to use AJAX to submit the form.

Some things to note here:
- We give the form a `x-ref` attribute so it can be targeted in Alpine easily.
- We use a nested `div` since the `{{ form }}` tag will already be outputting a `x-data` attribute.
- Precognition's `$form` helper expects a URL to submit. We grab that from the `action` attribute on the `<form>` tag that would be generated by `{{ form }}`.
- It also expects the initial form state. We grab that from the `x-data` attribute on the `<form>` tag. This data will use `old()` data appropriately.
- Any errors that come back from the full page submission get passed into Precognition's `$form` helper via `setErrors()`. We use the same Alpine templating to output the inline Precognition errors and the full page submission's errors.
- We need to override the [fieldtype's views](/tags/form-create#prerendered-field-html) so that `x-model` and `@change` are bound to the inputs as per the Precognition docs. The example below shows edits to the text field, but you would need to do it for all fieldtypes you plan to use.

::tabs

::tab antlers
```antlers
{{ form:contact attr:x-ref="form" js="alpine" }}
    <div x-data='{
        form: $form(
            "post",
            $refs.form.getAttribute("action"),
            JSON.parse($refs.form.getAttribute("x-data"))
        ).setErrors({{ error | json }}),
    }'>

        {{ if success }}
            Success!
        {{ /if }}

        <template x-if="form.hasErrors">
            <div>
                Errors!
                <ul>
                    <template x-for="error in form.errors">
                        <li x-text="error"></li>
                    </template>
                </ul>
            </div>
        </template>

        {{ fields }}
            <label>{{ display }}</label>
            {{ field }}
            <small x-show="form.invalid('{{ handle }}')" x-text="form.errors.{{ handle }}"></small>
        {{ /fields }}

        <button :disabled="form.processing">Submit</button>

    </div>
{{ /form:contact }}
```

```antlers
<!-- resources/views/vendor/statamic/forms/fields/text.antlers.html [tl! **]-->
<input
    type="{{ input_type ?? 'text' }}"
    name="{{ handle }}"
    value="{{ value }}"
    {{ if placeholder }}placeholder="{{ placeholder }}"{{ /if }}
    {{ if character_limit }}maxlength="{{ character_limit }}"{{ /if }}
    {{ if autocomplete }}autocomplete="{{ autocomplete }}"{{ /if }}
    {{ if js_driver }}{{ js_attributes }}{{ /if }} <!-- [tl! -- **] -->
    x-model="form.{{ handle }}"  <!-- [tl! ++ **] -->
    @change="form.validate('{{ handle }}')"  <!-- [tl! ++ **] -->
    {{ if validate|contains:required }}required{{ /if }}
>
```
::tab blade
```blade
<s:form:contact attr:x-ref="form" js="alpine">
  <div
    x-data="{
      form: $form(
        'post',
        $refs.form.getAttribute('action'),
        JSON.parse($refs.form.getAttribute('x-data'))
      ).setErrors(@json($error)),
    }"
  >
    @if ($success) Success! @endif

    <template x-if="form.hasErrors">
      <div>
        Errors!
        <ul>
          <template x-for="error in form.errors">
            <li x-text="error"></li>
          </template>
        </ul>
      </div>
    </template>

    @foreach ($fields as $field)
      <label>{{ $field['display'] }}</label>
      {!! $field['field'] !!}

      <small
        x-show="form.invalid('{{ $field['handle'] }}')"
        x-text="form.errors.{{ $field['handle'] }}"
      ></small>
    @endforeach

    <button :disabled="form.processing">Submit</button>
  </div>
</s:form:contact>
```

:::tip
By default, form input templates will be implemented in Antlers. The following template has been converted to Blade for your convenience.
:::

```blade
<!-- resources/views/vendor/statamic/forms/fields/text.blade.php [tl! **]-->
<input
  type="{{ $input_type ?? 'text' }}"
  name="{{ $handle }}"
  value="{{ $value ?? '' }}"
  @if (isset($placeholder)) placeholder="{{ $placeholder }}" @endif
  @if (isset($character_limit)) maxlength="{{ $character_limit }}" @endif
  @if (isset($autocomplete)) autocomplete="{{ $autocomplete }}" @endif
  @if (isset($js_driver)) {!! $js_attributes !!} @endif {{-- [tl! -- **] --}}
  x-model="form.{{ $handle }}" {{-- [tl! ++ **] --}}
  @change="form.validate('{{ $handle }}')" {{-- [tl! ++ **] --}}
  @required(in_array('required', $validate ?? []))
>
```
::

To build on the regular form submission example above, here's an example for AJAX submission:

::tabs

::tab antlers
```antlers
<div x-data='{
    form: $form(
        "post",
        $refs.form.getAttribute("action"),
        JSON.parse($refs.form.getAttribute("x-data"))
    ).setErrors({{ error | json }}), {{# [tl! --] #}}
    ), {{# [tl! ++:start] #}}
    init() {
        $refs.form.addEventListener("submit", evt => {
            evt.preventDefault();
            this.form.submit().then(response => {
                this.form.reset();
                console.log("Success")
            }).catch(error => {
                console.log(error);
            });
        });
    } {{# [tl! ++:end] #}}
}'>
```
::tab blade
```blade
<div x-data='{
    form: $form(
        "post",
        $refs.form.getAttribute("action"),
        JSON.parse($refs.form.getAttribute("x-data"))
    ).setErrors(@json($error)), {{-- [tl! --] --}}
    ), {{-- [tl! ++:start] --}}
    init() {
        $refs.form.addEventListener("submit", evt => {
            evt.preventDefault();
            this.form.submit().then(response => {
                this.form.reset();
                console.log("Success")
            }).catch(error => {
                console.log(error);
            });
        });
    } {{-- [tl! ++:end] --}}
}'>
```
::

[tags]: /tags/form
[submissions]: /tags/form-submissions
