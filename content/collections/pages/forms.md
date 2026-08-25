---
id: fdb45b84-3568-437d-84f7-e3c93b6da3e6
blueprint: page
title: Forms
template: page
intro: 'Forms are a natural part of the internet experience and a core component of most websites. From a basic "Contact Me" form to a multi-page job application, Statamic can help manage your forms, submissions, and thereby make your life a little bit easier.'
related_entries:
  - e4f4f91e-a442-4e15-9e16-3b9880a25522
---

Forms comes in two flavours: built-in and [Forms Pro](#forms-pro).

If you’re building a typical contact form, RSVP, or similar, the built-in Forms feature will probably be all you need. It’s included with Statamic core, so there’s nothing extra to install or purchase.

If you need [more](https://youtu.be/uNy_MLr8mXA?si=66HfGKi1asv6PmgM&t=13), Forms Pro is a separate paid add-on with advanced features like third-party integrations, enhanced workflows, and other powerful tools. You can [try it out for free locally](#installation).

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

:::tip
Statamic Core allows you to create a single form. To create any more, either enable [Statamic Pro](/getting-started/licensing) or install [Forms Pro](#forms-pro).
:::

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

Submissions marked as [spam](#spam-submissions) are also hidden by default. Switch the **Status** filter to **Spam** to review them.

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

**Connections** let you send submissions off to other places. Statamic ships with Email and Webhook connections out of the box.

You'll find them in the **Connect** area of your form in the Control Panel, along with how many of each are configured.

_TODO: Screenshot of the Connect area_

### Email

The Email connection sends emails whenever the form is submitted. You can add any number of emails to your form, each with their own settings.

The Recipient, CC, BCC, Sender and Reply-To fields suggest your form's fields — so you can send the email to whatever address the visitor submitted — and you can type email addresses in directly (including the `Jack Black <jack@jackblack.com>` syntax) to send to fixed addresses.

Each email can be sent for every submission, or only when the submission matches a set of conditions — like only sending the "sales" email when the visitor picked "Sales" from your enquiry type field.

_TODO: Screenshot of configuring an email_

#### The email body

You can write the email body directly in the Control Panel — no need to create any views. Use `@` to insert your form's fields into the body.

If you'd rather have full control over the email's design, you can specify custom HTML and Text views instead. To output the written body inside your view, use `{{ email_config:body }}`. When there's no body and no views, Statamic will send an "automagic" email — a simple text email with a list of all the fields and values in the submission.

[Learn how to create your emails](/email)

#### Email variables

Inside your email view, you have a number of variables available:

- `date`, `now`, `today` - The current date/time
- `site_url` - The site home page.
- `site`, `locale` - The handle of the site
- `config` - Any app configuration values
- `email_config` - The email's settings, keyed by the handles of the fields you filled in when configuring it — `{{ email_config:subject }}`, `{{ email_config:mailer }}`, and so on.
- `form_config` - Any extra config values appended to the form's blueprint (e.g. via addons using `Form::appendBlueprintTab()`)
- Any data from [Global Sets](/globals#global-sets)
- All of the submitted form values
- A `fields` array

The submitted form values will be augmented for you. For instance, an **Upload** field gives you Asset objects when **Store Files** is enabled, or plain file paths when it isn't. Or, a **Dropdown** field will be an array with `label` and `value` rather than just the value.

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

You can set a full "From" and "Reply-To" name in addition to the email address by typing it into the Sender or Reply-To fields using the following syntax:

```
Jack Black <jack@jackblack.com>
```

#### Dynamic recipients and subjects

The address fields suggest your form's fields — select one and the address the visitor submitted will be used when the email is sent. For example, selecting your "Email Address" field as the Reply-To means you can hit reply in your inbox to respond directly to the visitor.

The Subject field supports Antlers, so you can reference submitted values there too using their field handles:

```
{{ subject ?? "Email Form Submission" }}
```

#### Attachments

When using [file uploads](#file-uploads) in your form, you may choose to have those attached to the email by enabling the **Attachments** toggle.

If you don't want the attachments to be kept around on your server, configure your [Upload field](#file-uploads) so it doesn't store the files — they'll be attached to the email and then deleted.

#### Mailer

If your app has more than one [mailer configured](https://laravel.com/docs/mail#configuration), you can choose which one sends the email. Leave it blank to use your app's default mailer.

#### Using Markdown Mailable Templates

Laravel allows you to create email templates [using Markdown](https://laravel.com/docs/mail#markdown-mailables). It's pretty simple to wire these up with your form emails:

1. Enable the **Markdown** toggle when configuring the email.

2. Next, create a **Blade** view for your email template, select it as the **HTML view**, and start using Laravel's Markdown Mailable components:

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

You can customize the components further by reviewing the [Laravel documentation](https://laravel.com/docs/mail#customizing-the-components).

### Webhooks

The Webhook connection sends a POST request to a URL of your choice whenever the form is submitted. You can add any number of webhooks to your form and, like emails, each webhook can be sent for every submission or based on conditions.

The request contains the form's handle and the submission's data as JSON:

```json
{
    "form": "contact_us",
    "submission": {
        "id": "1753264619.65652",
        "date": "2026-07-23T10:00:00.000000Z",
        "name": "Jack Black",
        "email": "jack@jackblack.com"
    }
}
```

Only `http` and `https` URLs are supported. If you're developing locally, or sending requests to internal services with self-signed certificates, you can disable SSL verification per webhook.

_TODO: Screenshot of configuring a webhook_

### Building custom connections

You can build your own connections to send submissions anywhere you like.

Create a class in the `app/FormConnections` directory that extends `Statamic\Forms\Connections\Connection` and Statamic will discover it automatically. Addons can do the same in their `FormConnections` directory, or register classes explicitly using the `$formConnections` property on their service provider.

```php
<?php

namespace App\FormConnections;

use Statamic\Contracts\Forms\Form;
use Statamic\Forms\Connections\Connection;
use Statamic\Support\VueComponent;

class Acme extends Connection
{
    protected static $title = 'Acme';
    protected $description = 'Send submissions to Acme.';
    protected $icon = 'globe-arrow';
    protected $developer = 'Acme Inc.';

    public function count(Form $form): ?int
    {
        return count($form->connections()->get('acme', []));
    }

    public function render(Form $form): VueComponent
    {
        return VueComponent::render('acme-connection');
    }

    public function rules(Form $form): array
    {
        return [
            '*' => ['array'],
            '*.channel' => ['required'],
        ];
    }
}
```

#### Properties & Methods

| Property/Method | Description |
| --- | --- |
| `$title` | The title shown on the Connect index. Defaults to a title generated from the class name. |
| `$description` | A short description shown on the Connect index. |
| `$icon` | The icon shown on the Connect index. |
| `$developer` | Who built the connection, shown on the Connect index. |
| `count()` | The number shown in the "Connections" badge on the Connect index. Optional. |
| `render()` | The Vue component (and its props) rendered on the connection's edit page. |
| `preProcess()` | Prepares the saved config for editing. Whatever it returns is passed to your Vue component as its `modelValue`. Returns the config untouched by default. |
| `rules()` | Validation rules for the value being saved. |
| `process()` | Prepares the submitted value for saving. Whatever it returns gets saved to the form. Returns the value untouched by default. |
| `routes()` | Additional routes for the connection (eg. OAuth callbacks). They're registered under `/forms/{form}/connect/{handle}` and automatically wrapped in authorization. |
| `finalized()` | The job (or array of jobs) to be dispatched when a submission is finalized. |

#### Saving

You don't need any routes or controllers to save your connection — the edit page owns the whole save flow, including the save button, the <kbd>Cmd</kbd>+<kbd>S</kbd> shortcut, validation errors and dirty state tracking.

Your config makes a round trip through your connection class:

1. When the page loads, the saved config is passed through your `preProcess()` method and handed to your Vue component as its `modelValue`.
2. Your component emits `update:modelValue` as the user makes changes.
3. When the user saves, the value is sent back as-is, validated against your `rules()`, passed through your `process()` method, and saved to the form under your connection's handle.

The value is the request body itself, so your rules are keyed from the root — `*.channel` rather than nesting under some key — and validation errors come back keyed the same way (`0.channel`), passed to your component via the `errors` prop.

#### The frontend

The `render()` method determines which Vue component gets rendered, along with its props.

Your component is rendered inside the connection's edit page, which passes it three props automatically — `form`, `modelValue` containing the pre-processed value, and `errors` containing any validation errors. You don't need to pass any of these through `render()` yourself.

If your connection supports multiple "rows" (eg. multiple emails per form), you can use the `<ConnectionRows>` component to get a head start.

Pass it your array of rows via `v-model`, your validation errors via `errors`, and a header slot and a body slot for each row. It takes care of the collapsible row UI and the add/duplicate/remove actions. New rows are seeded from `defaults.values`, and each row is given an `id`, `enabled` state and empty `conditions` for you.

```vue
<script setup>
import { ConnectionRows } from '@statamic/cms';
import { Badge } from '@statamic/cms/ui';

defineEmits(['update:modelValue']);

defineProps({
    modelValue: { type: Array, default: () => [] },
    errors: { type: Object, default: () => ({}) },
    defaults: Object,
});
</script>

<template>
    <ConnectionRows
        :model-value="modelValue"
        :errors
        :defaults
        :add-label="__('Add Notification')"
        @update:model-value="$emit('update:modelValue', $event)"
    >
        <template #header="{ item: notification, collapsed }">
            <Badge size="lg" pill>{{ notification.channel || __('New Notification') }}</Badge>
        </template>

        <template #default="{ item: notification, errors }">
            <!-- Each row's fields go here... -->
        </template>
    </ConnectionRows>
</template>
```

The default slot hands each row its own validation errors, grouped by field handle, ready to pass along to your fields.

#### Conditional logic

If you want your connection to support conditional logic, the `<ConnectionRules>` component renders the logic builder. Bind your conditions with `v-model:conditions` and put whatever the conditions control inside its `then` slot.

```vue
<template #default="{ item: notification, index }">
    <ConnectionRules
        v-model:conditions="notification.conditions"
        :always-label="__('Always send')"
        :if-label="__('Send if...')"
    >
        <template #then>
            <!-- The fields controlled by the conditions go here... -->
        </template>
    </ConnectionRules>
</template>
```

On the PHP side, the `Statamic\Forms\Connections\ConnectionLogic` class handles the rest:

- When editing, `ConnectionLogic::preProcess($conditions)` gives each condition the row ID the logic builder needs — call it on each row's conditions from your connection's `preProcess()` method.
- When saving, `ConnectionLogic::process($conditions)` strips out the row IDs and any incomplete conditions, and returns `null` when there's nothing to save — call it from your `process()` method.
- When a submission comes in, `ConnectionLogic::passes($config, $submission)` tells you whether a row should run — it fails when the row has been disabled, or when its conditions don't match the submission.

Statamic also exports `conditionsSummary`, which turns a row's conditions into a readable sentence — like _"if Enquiry Type equals Sales"_ — handy for describing a row in its header when collapsed.

```vue
<script setup>
import { conditionsSummary } from '@statamic/cms';
</script>

<template #header="{ item: notification, collapsed }">
    <Badge size="lg" pill>{{ notification.channel || __('New Notification') }}</Badge>
    <Subheading v-show="collapsed">{{ conditionsSummary(notification.conditions) }}</Subheading>
</template>
```

#### Sending notifications

When a submission is finalized, Statamic dispatches a single job chain: file uploads are converted to assets, then each of the connection jobs run and finally temporary file uploads are deleted.

To hook into this process, return a job (or array of jobs) from the `finalized()` method:

```php
public function finalized($submission): object|array
{
    return new SendNotificationToThirdPartyService($submission);
}
```

Because Statamic uses Laravel's [job chaining](https://laravel.com/docs/queues#job-chaining) feature, if you need to dispatch additional jobs within one of your jobs, call `$this->prependToChain($job)` (from Laravel's `Queueable` trait) so they stay part of the chain.

## File uploads

Maybe your fans want to send a photo, or you're collecting resumes and cover letters. Whatever the files, add an **Upload** field to your form and you're collecting them.

When configuring the Upload field, you decide whether the uploaded files should be kept around:

- **Store the files** and they'll be permanently saved as reusable [Assets](/assets) in the asset container you choose.
- **Don't store the files** and they'll only stick around long enough to be sent with your form's [connections](#connections) (like email attachments), then they'll be deleted shortly after the form is submitted.

You can also set a maximum number of files to control whether respondents can upload a single file or several.

### Configuring temporary file storage

When using the `files` fieldtype, uploads are temporarily stored on your server before being attached to emails and then deleted. By default, these files are stored on the `local` disk at `storage/app/private/statamic/file-uploads`.

In multi-server environments where a file might be uploaded on one server but processed (eg. queued form emails) on another, you can configure the storage location to use a shared filesystem like S3:

```env
STATAMIC_FILE_UPLOADS_DISK=s3
STATAMIC_FILE_UPLOADS_PATH=statamic/file-uploads
```

Or in your `config/statamic/system.php` file:

```php
'file_uploads_disk' => env('STATAMIC_FILE_UPLOADS_DISK', 'local'),
'file_uploads_path' => env('STATAMIC_FILE_UPLOADS_PATH', 'statamic/file-uploads'),
```

:::tip
Since these are temporary files containing user uploads, you should use a private filesystem to prevent unauthorized access.
:::

## Restricting submissions

Sometimes you don't want a form to accept submissions forever. From the form's settings, under **Access**, you can restrict submissions using any combination of:

- **Close Date** — the form stops accepting submissions after this date.
- **Submission Limit** — the maximum number of submissions to accept, optionally scoped to a period (Total, Per Day, Per Week, or Per Month). The limit resets at the app timezone's midnight, start of the week, or start of the month.
- **Require Login** — only logged in visitors may submit the form.

Statamic rejects restricted submissions server-side with a validation error, so nothing gets through even if you don't check for it in your template. You can also hide or replace the form's contents on the front-end using the `restricted` and `restriction_message` variables:

```antlers
{{ form:contact }}
    {{ if restricted }}
        <p>{{ restriction_message }}</p>
    {{ else }}
        {{ fields }} ... {{ /fields }}
    {{ /if }}
{{ /form:contact }}
```

The message shown for a closed or limit-reached form can be customized with the **Closed Message** setting, and the message shown when login is required can be customized separately with **Require Login Message**. Leave either blank to use Statamic's default wording. If a form is both closed/limit-reached and requires login, the closed message takes precedence.

:::tip
When a form has [Forms Pro](#forms-pro)'s [Unique Instances](#unique-instances) enabled, these restrictions are checked per entry — and each entry can override them.
:::

## Localizing forms

Form fields aren't yet localizable — a field's display label, instructions, and options are shared across every site. We're planning on adding support for this soon.

In the meantime, you have a couple of options if you need a form's labels translated per site:

- Use the [Translation Manager](https://statamic.com/addons/thoughtco/translation-manager) addon by Thought Collective, which lets you manage translations for content that isn't otherwise localizable.
- Duplicate the form once per site, and translate its labels, instructions, and options by hand.

## Honeypot

Simple and effective spam prevention.

The honeypot technique is simple. Add a field to your forms, that when filled in will cause the submission to fail, but appear successful. By default, nothing will be saved and no [connections](#connections) are triggered.

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

### Honeypot behavior

The **Honeypot Behavior** setting on the form's configuration screen controls what happens to submissions caught by the honeypot:

- **Ignore** (default): the submission is silently discarded.
- **Save as Spam**: the submission is stored and [marked as spam](#spam-submissions), so you can review it later.

Either way, the visitor receives the same response as a successful submission, so bots can't tell they've been caught.

## Spam submissions

Rather than being discarded, submissions caught by spam protection can be kept out of sight for review. A submission marked as spam is hidden from the submissions listing by default, doesn't count towards [submission limits](#restricting-submissions), and doesn't trigger any [connections](#connections).

To review them, switch the **Status** filter on the submissions listing to **Spam**. From there, you can use the **Mark as Spam** and **Mark as Not Spam** actions.

When a submission that was caught before being finalized (by the [honeypot](#honeypot), for example) is marked as not spam, it gets finalized as normal — triggering any configured [connections](#connections) at that point. Submissions that were manually flagged after being finalized simply have the flag removed, so nothing is re-triggered.

### Marking submissions as spam from addons

The honeypot is the first thing to take advantage of the spam status, but addon developers can also mark submissions as spam inside event listeners:

```php
use Illuminate\Support\Facades\Event;
use Statamic\Events\FormSubmitted;

Event::listen(function (FormSubmitted $event) {
    if (Akismet::isSpam($event->submission)) {
        $event->submission->markAsSpam()->save();

        return false;
    }
});
```

Returning `false` halts the submission pipeline while still giving the visitor a successful response. Since the submission was saved as spam beforehand, it'll be waiting in the submissions listing for review.

You can find more details about working with spam submissions in the [Form Submission Repository](/repositories/form-submission-repository#spam-submissions) docs.

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

Consult the [Laravel documentation](https://laravel.com/docs/routing#rate-limiting) to learn more about defining rate limiters.

## Submitting forms programmatically

The [`form:create`](/tags/form-create) tag handles submissions for you, but you can also submit a form yourself using the `SubmitForm` action. This makes it easy to submit forms from a Livewire component, a custom controller, or your own API endpoint.

```php
use Statamic\Facades\Form;
use Statamic\Forms\SubmitForm;
use Statamic\Exceptions\FormRestrictedException;
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
} catch (FormRestrictedException $e) {
    // The form is closed, its submission limit has been reached, or
    // it requires login and the visitor is logged out.
    return back()->withErrors(['*' => $e->getMessage()]);
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
| `entry` | Optional. (intended to be used alongside Forms Pro's [unique instances](#unique-instances) feature) ID of the entry the submission is attached to. |
| `resume` | `Submission` instance of the partial submission you wish to resume. |
| `submit` | Submit the form. Accepts an array of `$data` and an optional array of `$files`. Returns a `SubmissionResult` object containing the submission and the ID of the next page (in the case of a multi-page form). |
| `validate` | Validate the current page. Accepts an array of `$data` and an optional array of `$files`. Also accepts an array of field handles to limit which fields are validated. |

The action also throws various exceptions:

- `SilentFormFailureException` is thrown when the [honeypot](#honeypot) catches spam, or an event listener returns `false` from the [`FormSubmitted`](/events#formsubmitted) event — so spam bots still see a success response. The submission data is available via `$e->submission()`.
- `FormRestrictedException` is thrown when a form is [restricted](#restricting-submissions). Its message is the form's [restriction message](#restricting-submissions), and the restricted `Form` is available via `$e->form()`.

## Forms Pro

Need more from your forms? [Forms Pro](https://statamic.com/addons/statamic/forms-pro) is a paid addon that builds on Statamic's built-in forms with features like:

- [Address fieldtype](#address-fieldtype)
- [Multi-page forms](#multi-page-forms)
  - [Controlling page logic](#controlling-page-logic)
  - [The page logic tree view](#tree-view)
  - [Customizing page buttons](#customizing-page-buttons)
- [Form summaries](#form-summaries)
- [Form summary graphs](#form-summary-graphs)
- [Automagic Forms](#automagic-forms)
- [Unique form instances per entry](#unique-instances)
- [Connections for HubSpot, Mailchimp and more](#connections-1)
- Additional fieldtypes
- [Spam prevention with Cloudflare Turnstile](#cloudflare-turnstile)

### Installation

1. You can install the Forms Pro addon via Composer:

   ```bash
   composer require statamic/forms-pro
   ```

2. Next, publish the configuration file to `config/forms-pro.php`:

   ```bash
   php artisan vendor:publish --tag=forms-pro-config
   ```

3. You can now use Forms Pro's features when building and configuring forms in the Control Panel.

### Connections

Alongside the Email and Webhook connections that ship with Statamic, Forms Pro adds connections for a number of third-party services. You'll find them in the same **Connect** area of your form.

When you set each one up, it'll guide you through getting everything connected.

_TODO: Screenshot of the Connect area showing the Forms Pro connections_

#### Google Sheets

Adds submissions as rows in a [Google Sheet](https://workspace.google.com/products/sheets/). You paste the spreadsheet's address, choose a tab, and pick which fields become columns — or leave that empty to include everything.

Rows are added to the bottom, so your existing rows are left alone. Columns are named after field handles, and appear the first time a field is submitted.

#### HubSpot

Sends submissions to a form in your [HubSpot](https://www.hubspot.com) account, so any workflows and follow-up emails attached to that form run as normal.

You choose which of the HubSpot form's properties to map to your fields, and if it collects GDPR consent, you can map those options too.

If you've added HubSpot's tracking code to your site, submissions will be linked to the visitor's browsing history. You'll want to turn off "Collect data from website forms" in HubSpot, otherwise it'll record its own copy of every submission.

#### Kit

Subscribes people to your [Kit](https://kit.com) account. You can map custom fields and apply tags to subscribers — they'll need to exist in Kit first so you can pick them.

Subscribers can also be attributed to a Kit form, so any automations linked to it will run.

#### Mailchimp

Subscribes people to a [Mailchimp](https://mailchimp.com) audience. You can apply tags, map fields to the audience's merge fields, add people to groups based on what they chose, and record GDPR marketing permissions against the contact.

New subscribers are added as pending until they confirm by email, unless you turn on "Skip Confirmation Email".

#### Mailcoach

Subscribes people to a [Mailcoach](https://www.mailcoach.app) email list. You can apply tags and store extra values as attributes.

For lists using double opt-in, "Skip Confirmation Email" subscribes people immediately rather than asking them to confirm.

#### Slack

Posts submissions to a [Slack](https://slack.com) channel, with a button linking through to the submission in the Control Panel. You can write your own heading and choose which fields to include.

#### Twilio

Sends a text message via [Twilio](https://www.twilio.com) when the form is submitted. Text a fixed number, or pick a form field to text whoever submitted. The message body can include values from the submission.

### Address fieldtype

Forms Pro ships an **Address** fieldtype with localized field labels and autocomplete powered by [Google Places](https://developers.google.com/maps/documentation/places/web-service/place-autocomplete) or [Geoapify](https://www.geoapify.com/).

#### Localization

Address formats differ by country, so the field adapts itself to country changes:

- The "Region" label becomes "State", "Province", "County", "Prefecture", and so on. It's hidden entirely for countries that don't use one.
- The "Postcode" label becomes "ZIP Code", "Postal Code", "Eircode", and so on. It's likewise hidden where it doesn't apply.
- Some countries (the US, Canada, China, and Italy) require a region, so it's marked as required even when the field as a whole is optional.

You can set a **Default Country** in the field's configuration to control which country — and therefore which labels — are shown by default.

#### Autocomplete

To enable autocomplete, specify a provider and publishable API key in your `.env`:

```env
FORMS_PRO_ADDRESS_AUTOCOMPLETE_PROVIDER=google # or: geoapify
FORMS_PRO_ADDRESS_AUTOCOMPLETE_KEY=your-key
```

Typing into the "Line 1" field suggests addresses; picking one fills in the rest of the fields. Forms Pro supports two autocomplete providers:

- **Google Places** — the best data, and the only provider that returns unit numbers, handles UK postal towns, and per-country administrative levels. A billing account (payment method) is required to obtain an API key.
- **Geoapify** — free up to 3,000 requests per day. It doesn't have the concept of a "subpremise" — the sub-unit of a building, like a flat number in the UK — so it won't fill in Line 2.

#### Customizing the front-end

Like Statamic's own form fieldtypes, the Address fieldtype ships with basic stubs to get up and running. If you wish to customize how the field is rendered, you may publish the Antlers/Blade views into your project with:

```bash
php artisan vendor:publish --tag=forms-pro-fields
```

The stubs will be published to `resources/views/vendor/forms-pro/forms`.

You'll also need to publish Forms Pro's JS and add it to your layout. Without it, the field still renders and submits, but labels won't localize and autocomplete won't work:

```bash
php artisan vendor:publish --tag=forms-pro-frontend
```

```html
<script src="/vendor/forms-pro/frontend/js/forms-pro.js"></script>
```

Forms Pro binds what it needs to `data` attributes, so as long as you keep them, you're free to customize the markup:

- `data-forms-pro-address` — the root element.
- `data-address-field` — wraps a sub-field, so it can be hidden for countries that don't use it.
- `data-address-input` — the `<input>`/`<select>` itself. Read and written by autocomplete.
- `data-address-error` — where a validation error is displayed.
- `data-labels` and `data-autocomplete` — configuration, passed through from the fieldtype.

##### Autocomplete markup

You can find the suggestions dropdown's markup in the published view:

```antlers
<template data-address-suggestions>
    <ul class="absolute z-10 mt-1 w-full rounded-md border bg-white shadow-lg">
        <li data-address-option class="px-3 py-2 aria-selected:bg-gray-100">
            <span data-address-label></span>
        </li>
        <li data-address-attribution class="px-3 py-1 text-xs text-gray-500"></li>
    </ul>
</template>
```

- `[data-address-option]` is a prototype, cloned once per suggestion.
- `[data-address-label]` is where the suggestion text is written. It's optional — omit it and the text goes into the option itself.
- `[data-address-attribution]` receives the provider's required attribution, and must not be removed.

Forms Pro applies the roles, IDs, and ARIA state itself, so restyling can't break the combobox. Since the active option is marked with `aria-selected`, Tailwind's `aria-selected:` variant is enough for the highlight state.

The dropdown is inserted directly after the "Line 1" input, so give that field's wrapper `position: relative` to position it.

### Multi-page forms

When it comes to creating form logic, you can already show and hide fields based on a user's previous responses. Forms Pro supercharges this by introducing **multi-page forms**.

This is especially useful for longer forms. Breaking them into pages makes them easier to complete, and gives you greater control over the user journey—skipping entire sections or guiding users down different paths based on their answers.

<figure>
  <img src="/img/forms-pro/page-logic.webp" alt="Page logic for Forms Pro in the control panel" class="u-hide-in-dark-mode">
  <img src="/img/forms-pro/page-logic-dark.webp" alt="Page logic for Forms Pro in the control panel" class="u-hide-in-light-mode">
  <figcaption>With Forms Pro you get page logic <em>as well as</em> field logic</figcaption>
</figure>

:::warning
The `SubmissionCreating`, `SubmissionCreated`, `SubmissionSaving` and `SubmissionSaved` events are dispatched when creating partial submissions, just like any other submission.

If you're listening to these events in your code, and _don't_ want to receive incomplete submissions, you should listen to either the [`FormSubmitted`](https://statamic.dev/backend-apis/events/events#formsubmitted) or [`SubmissionFinalized`](https://statamic.dev/backend-apis/events/events#submissionfinalized) events instead.
:::

#### Controlling page logic

With Forms Pro you can control page logic in a few different ways:

<ol>
  <li>
    <p>The Edit tab — edit page logic <strong>inline</strong>. This is useful for adjusting logic "as you go", by clicking on the page name in Edit mode, and selecting the logic tab.</p>
    <figure>
      <img src="/img/forms-pro/editing-logic-inline.webp" alt="Edit page logic for Forms Pro in the control panel" class="u-hide-in-dark-mode">
      <img src="/img/forms-pro/editing-logic-inline-dark.webp" alt="Edit page logic for Forms Pro in the control panel" class="u-hide-in-light-mode">
      <figcaption>Edit page logic as you go in the control panel</figcaption>
    </figure>
  </li>
  <li>
    <p>The logic tab <strong>(List view)</strong>. See page and field-level logic side by side, then open any rule to inspect and refine it.</p>
    <figure>
      <img src="/img/forms-pro/editing-logic-list.webp" alt="Edit page logic in a list view" class="u-hide-in-dark-mode" style="border-bottom-left-radius: 14px; border-bottom-right-radius: 14px;">
      <img src="/img/forms-pro/editing-logic-list-dark.webp" alt="Edit page logic in a list view" class="u-hide-in-light-mode">
      <figcaption>All your form logic in a dedicated list</figcaption>
    </figure>
  </li>
  <li id="tree-view">
    <p>The logic tab <strong>(Tree view)</strong>. This is useful for comprehending and adjusting more complex page logic.</p>
    <figure>
      <img src="/img/forms-pro/tree-view.webp" alt="Edit page logic for Forms Pro in the control panel" class="u-hide-in-dark-mode">
      <img src="/img/forms-pro/tree-view-dark.webp" alt="Edit page logic for Forms Pro in the control panel" class="u-hide-in-light-mode">
      <figcaption>See and arrange everything with the tree view. Drag and drop to reorder pages and rules. You have now reached Marie Kondo level of form organisation 💅</figcaption>
    </figure>
  </li>
</ol>

:::tip
When you select a field or page, a side panel opens on the right so you can edit it. If the selected field has connected page logic, other connections are dimmed, making it easier to follow the one you’ve selected.

The tree view uses `Esc` as a handy power-user shortcut. Press it once to clear your selection. Press it again to close the side panel and return to the full-width view.
:::

#### Customizing page buttons

Page buttons default to “Next” and “Previous” but you can customize them to say whatever you want. Tease your users with something informative or cheeky—“Let's find out what Star Sign you are!”, “Ready to find out your perfect career?”, “Which Ninja Turtle are you?”, etc.

<figure>
  <img src="/img/forms-pro/customize-button-text.webp" alt="Customize button text for Forms Pro" class="u-hide-in-dark-mode">
  <img src="/img/forms-pro/customize-button-text-dark.webp" alt="Customize button text for Forms Pro" class="u-hide-in-light-mode">
  <figcaption>Customize button text for Forms Pro</figcaption>
</figure>

#### Templating
When a visitor submits a page, Statamic validates its fields and saves a "partial" submission. The submission is only finalized (dispatching events and triggering connections) once the final page is submitted.

Provided you're using the `{{ form:create }}` tag to render your form, you **don't need to make any changes to your template** to support multi-page forms.

The `{{ sections }}` and `{{ form:fields }}` loops are automatically scoped to the current page. Submitting the form will take you to the next page.

Forms Pro makes the following variables available on each page:

| Variable              | Description                                                                 |
|-----------------------|-----------------------------------------------------------------------------|
| `page:display`        | The page's display name.                                                    |
| `page:instructions`   | The page's help text.                                                       |
| `button_label`        | Label for the submit button.                                                |
| `previous_page_url`   | URL to navigate back to the previous page. Not available on the first page. |
| `previous_page_label` | Label for the "previous page" link.                                         |

Apart from wiring up button labels and a link back to the previous page, you can use an existing template as-is:

```antlers
{{ form:survey }}
    {{ if success }}
        <p>Success!</p>
    {{ /if }}

    <h2>{{ page:display }}</h2>
    <p>{{ page:instructions }}</p>

    {{ sections }}
        <fieldset>
            <legend>{{ display }}</legend>
            {{ form:fields }}
                <div>
                    <label>{{ display }}</label>
                    <p>{{ instructions }}</p>
                    {{ field }}
                    {{ if error }}
                        <p>{{ error }}</p>
                    {{ /if }}
                </div>
            {{ /form:fields }}
        </fieldset>
    {{ /sections }}

    {{ if previous_page_url }}
        <a href="{{ previous_page_url }}">{{ previous_page_label }}</a>
    {{ /if }}

    <button>{{ button_label }}</button>
{{ /form:survey }}
```

:::warning
When moving between pages, fields are pre-populated from the visitor's partial submission.
If you're using [static caching](https://statamic.dev/static-caching), you should wrap your forms in the [`{{ nocache }}`](https://statamic.dev/tags/nocache) tag to prevent submitted data from being cached.
:::

#### Submitting with JavaScript
Out of box, every page is submitted with a native `<form>` POST, incurring a full page reload.

Forms Pro ships with two Alpine JS drivers — `forms_pro_alpine` and `forms_pro_alpine_precognition` — that manage page state on the frontend and submit intermediate pages over AJAX, letting your visitors move between pages without a full page reload. They build on Statamic's [core Alpine drivers](https://statamic.dev/tags/form-create#logic-conditional-fields).

Forms Pro is responsible for submitting intermediate pages, leaving the final submission up to you.

To use them, first publish the frontend assets:

```bash
php artisan vendor:publish --tag=forms-pro-frontend
```

Then load the script, alongside Statamic's helpers:

```html
<script src="/vendor/statamic/frontend/js/helpers.js"></script>
<script src="/vendor/forms-pro/frontend/js/forms-pro.js"></script>
```

In your template, add `js="forms_pro_alpine"` (or `forms_pro_alpine_precognition`) to the form tag to enable the driver.

```diff
- {{ form:survey }}
+ {{ form:survey js="forms_pro_alpine" }}
```

Next, loop through `{{ pages }}` and wrap each page in `<template x-if="{{ show_page }}">`. Make sure anything page-related (like the page's display name and button labels) is _inside_ the loop and without the `page:` prefix.

Also, add click handler to the previous/next buttons to call `formsPro.goToPreviousPage()` and `formsPro.submit($event)` respectively.

```antlers
{{ form:survey js="forms_pro_alpine" }}
   {{-- ... --}}

   {{ pages }}
       <template x-if="{{ show_page }}">
            <h2>{{ display }}</h2>
            <p>{{ instructions }}</p>

            {{ sections }}
                {{-- ... --}}
            {{ /sections }}

            {{ if previous_page_label }}
                <button type="button" @click="formsPro.goToPreviousPage()">{{ previous_page_label }}</button>
            {{ /if }}

            <button @click="formsPro.submit($event)" :disabled="formsPro.submitting">{{ button_label }}</button>
       </template>
   {{ /pages }}

   {{-- ... --}}
{{ /form:survey }}
```

Finally, render validation errors for each field using `formsPro.errors['{{ handle }}']` in addition to your existing error handling. Forms Pro's error handling will be used for intermediate pages, but you'll need to display errors for the final page separately.

```php
<small
    x-show="formsPro.errors['{{ handle }}']"
    x-text="formsPro.errors['{{ handle }}']"
></small>
```

The following helpers are available in your templates:

##### State

| Property               | Description                                                    |
|------------------------|----------------------------------------------------------------|
| `formsPro.currentPage` | Handle of the page currently being shown.                      |
| `formsPro.pages`       | Array of all pages.                                            |
| `formsPro.errors`      | Validation errors for the current page, keyed by field handle. |
| `formsPro.submitting`  | `true` while a page is being submitted over AJAX.              |
| `formsPro.visited`     | Handles of the pages visited so far.                           |

##### Getters

| Property               | Description                            |
|------------------------|----------------------------------------|
| `formsPro.page`        | The current page object.               |
| `formsPro.pageIndex`   | Zero-based index of the current page.  |
| `formsPro.isFirstPage` | Whether the current page is the first. |
| `formsPro.isFinalPage` | Whether the current page is the last.  |

##### Methods

| Method                        | Description                                                                       |
|-------------------------------|-----------------------------------------------------------------------------------|
| `formsPro.submit($event)`     | Submit the current page over AJAX and advance to the next.                        |
| `formsPro.goToPage(pageId)`   | Jump to a previously visited page. Forward jumps and unvisited pages are ignored. |
| `formsPro.goToPreviousPage()` | Go back to the previous page.                                                     |
| `formsPro.goToFirstPage()`    | Jump back to the first page.                                                      |

All methods are namespaced under `formsPro` to avoid conflicts with your own Alpine data. This means that methods need to be called with `()` — bare references like `@click="formsPro.submit"` won't bind correctly.

#### Building your own driver
While the Alpine drivers are the easiest way to get started, you can also build your own driver.

Statamic's [custom JS drivers](https://statamic.dev/tags/form-create#custom-js-drivers) documentation covers how a driver is built and registered; this section covers what a driver needs to do to support multi-page forms specifically.

A page-aware driver has two responsibilities: **tracking the active page**, and **submitting intermediate pages over AJAX**.

##### Tracking page state
Render every page up-front (using the `{{ pages }}` loop), then only show the current page to the visitor. At a minimum, you'll want to keep track of:

- the current page
- the pages the visitor has already visited (so you can offer a "previous" button)
- the validation errors for the current page

The `{{ form:create }}` tag outputs a hidden `_page` input with the current page's ID. You should keep this up to date as the visitor moves between pages.

##### Submitting a page

When the visitor submits a page, you should:

- Send a `POST` request to the form's `action` URL
- Include the `_page` field, so Forms Pro knows which page to process
- Send an `X-Requested-With: XMLHttpRequest` header so Statamic responds with JSON rather than a redirect

On a **successful** response (`200`), the page's fields will be validated, a partial submission will be created, and the ID of the next page will be returned.

```json
{
   "success": true,
   "submission_created": true,
   "submission": { ... },
   "redirect": "https://example.com/survey?page=page_2",
   "next_page": "page_2"
}
```

When filled, you should advance to the next page using JavaScript. When empty, you should redirect the visitor to the `redirect` URL or show a success message.

On a **validation failure** (`400`), Statamic returns the errors for the current page's fields:

```json
{
    "errors": ["The name field is required."],
    "error": { "name": "The name field is required." }
}
```

You may use the `error` object (keyed by field handle) to display messages against every field, and keep the visitor on the current page.

The final page's submission is left up to you — let the native `<form>` POST handle it, or submit it over AJAX like the intermediate pages.

#### Logic

By default, submitting a page takes the visitor to the next page in sequence. However, **logic** can be used to skip pages, or branch out to different pages based on the answers they provide.

Logic can be configured in the **Form Builder**, under the "Logic" tab when inspecting a page. Pages can have multiple rules, and each rule can have multiple conditions, paired with a destination (the page to jump to when those conditions are met). You can also manage logic from the "Logic" page in the Control Panel.

When a page is submitted, its rules are evaulated in order. The first rule whose conditions pass wins, and the visitor is taken to its destination. If no rule matches, they continue to the next page in sequence. When there's nowhere left to go, the submission is finalized.

Unlike field logic, page logic is evaluated on the server, so logic behaves identically whether you're using plain POSTs or one of the JS drivers.

##### Combining conditions with _and_ / _or_

Every condition is joined to the previous one with **and** or **or**. Conditions are grouped so that **and** binds more tightly than **or**: a new group begins at each **or**, a group passes when _all_ of its conditions pass, and the rule passes when _any_ group passes.

Confused? Here's a visual example:

> `country` is `United States` **and** `state` is `California`
> **or** `country` is `Canada`

...is evaluated as `(country is United States and state is California) or (country is Canada)`.

### Form summaries

Forms Pro lets you view a summary of your form responses without needing to export submissions.

This is useful for spotting trends in your responses. See how many people signed up to your newsletter, or find out whether Robert Smith fans are also secretly listening to Olivia Rodrigo.

<figure>
  <img src="/img/forms-pro/form-summaries.webp" alt="A summary of form responses the control panel, showing various graph types and questions" class="u-hide-in-dark-mode">
  <img src="/img/forms-pro/form-summaries-dark.webp" alt="A summary of form responses the control panel, showing various graph types and questions" class="u-hide-in-light-mode">
  <figcaption>View a summary of form responses without leaving the control panel</figcaption>
</figure>

### Form summary graphs

Each fieldtype automatically displays a certain graph type — for example, the Dictionary fieldtype displays as a lollipop bar chart (yummy), and multi choice fieldtypes display as pie charts. These were designed to display the data in a way that's easy to understand and best represent the data.

Here are some other things worth knowing about graphs:

- If there’s more data than can fit in a graph, pagination controls will appear in the top-right corner, letting you page through the remaining results.
- Some fieldtypes, such as the Dictionary fieldtype, support multiple graph styles. Simply click the graph type icon in the top-right corner to switch between them.
- The Rating fieldtype automatically chooses the most appropriate layout. Ratings below 5 are shown as a horizontal bar chart, while ratings of 5 or more are displayed as a vertical bar chart.

### Automagic Forms

Sometimes you don't want to build a page for a form at all. **Automagic Forms** gives every form its own hosted, shareable page — no template or entry required. It's positioned similarly to Google Forms or Typeform's form pages, so non-technical clients can build and share a form without switching to another system.

Form pages support your own branding, multi-page navigation, a progress bar, real-time validation, and file uploads.

#### Enabling it on a form

Each form has an **Automagic Forms** section in its configuration. Flip the **Enable Automagic Form** toggle and the form goes live at its own shareable URL.

Once enabled, you can:

- Copy the **Automagic Form URL** and share it with anyone you'd like to fill it out.
- Customize the **Success Heading** and **Success Message** shown after a visitor submits.
- Turn on **Let visitors fill out the form again?** to show a button on the confirmation page for starting a new submission, with a customizable **Fill out again button label**.

#### The form's URL

Automagic Forms live at `/forms/{handle}`, so a form with the handle `contact` is served at `https://example.com/forms/contact`.

If `/forms` clashes with something else on your site, or you'd just prefer something different, change the `route` in `config/forms-pro.php`:

```php
'automagic_forms' => [
    'route' => 'get-in-touch', // [tl! focus]
    // ...
],
```

On a [multi-site](/multi-site) install, each site serves the form at its own URL, built from that site's URL.

For example: a French site at `/fr` serves it at `/fr/forms/contact`, and a site on its own domain serves it at `https://example.fr/forms/contact`.

#### Branding

You can customize the look and feel of your Automagic Forms from **Addons → Forms Pro** in the Control Panel:

- **Logo** — shown in the top-left corner of every Automagic Form. The asset container it's picked from can be set via `asset_container` in `config/forms-pro.php`; it defaults to your first container.
- **Brand Color** — overrides the color used for buttons and the progress bar. Leave it blank to use the default colors.
- **Background** — the background pattern shown behind every Automagic Form, picked from Steve Schoger's [Heropatterns](https://heropatterns.com/).

#### Disabling Automagic Forms

Automagic Forms are enabled by default. If you'd rather disable them entirely, turn them off in `config/forms-pro.php`:

```php
'automagic_forms' => [
    'enabled' => false,
    // ...
],
```

### Unique Instances

Sometimes one form needs to act like many. Picture an Events collection where every event has its own RSVP form — you don't want one big pile of RSVPs, you want to know who's coming to _which_ event, close registrations per event, and cap the numbers per event.

Rather than duplicating the form for every entry, **Unique Instances** lets a single form be shared across your entries, with each entry treated as its own instance. Submissions are attached to the entry they were submitted from, and [restrictions](#restricting-submissions) like close dates and submission limits apply per entry — with the option to override them per entry too.

#### Enabling it on a form

On the form's configure screen, under **Submissions**, flip the **Unique Instances** toggle. (You'll only see it when Forms Pro is installed.)

#### Attaching the form to entries

Add a [Form fieldtype](/fieldtypes/form) to your collection's blueprint and select the form on each entry. In your template, pass the selected form to the `{{ form:create }}` tag as usual:

::tabs

::tab antlers
```antlers
{{ form:create :in="rsvp_form:handle" }}
    ...
{{ /form:create }}
```
::tab blade
```blade
<s:form:create :in="$rsvp_form->handle">
    ...
</s:form:create>
```
::

When the tag is rendered on an entry's page, it automatically outputs a hidden `_entry` input containing the entry's ID — no template changes needed.

Submissions to a unique instances form **must** come from an entry. If the `_entry` input is missing, or doesn't point to a real entry, the submission is rejected with a validation error.

#### Submissions

Each submission stores the ID of the entry it was submitted from. The `entry` value is augmented into the entry itself, so you can use its variables when [displaying submission data](#displaying-submission-data):

::tabs

::tab antlers
```antlers
{{ form:submissions in="rsvps" }}
    {{ name }} is coming to {{ entry:title }}!
{{ /form:submissions }}
```
::tab blade
```blade
<s:form:submissions in="rsvps">
    {{ $name }} is coming to {{ $entry->title }}!
</s:form:submissions>
```
::

And since `entry` is stored like any other value, you can filter by it using [conditions](/conditions) — handy for showing an entry's own submissions on its page:

::tabs

::tab antlers
```antlers
{{ form:submissions in="rsvps" :entry:is="id" }}
    {{ name }} is coming!
{{ /form:submissions }}
```
::tab blade
```blade
<s:form:submissions in="rsvps" :entry:is="$id">
    {{ $name }} is coming!
</s:form:submissions>
```
::

#### Per-entry restrictions

When unique instances is enabled, [submission restrictions](#restricting-submissions) are checked against the entry being submitted from. A submission limit of 100 means 100 submissions _per event_, not 100 across the whole form. The same goes for close dates, closed messages, and requiring login — and the `restricted`, `restriction_message`, and `status` variables on the `{{ form:create }}` tag reflect the current entry's instance, so your existing template handles it all.

The form's own **Access** settings act as defaults, and each entry can override them. On the entry's publish form, use the Form fieldtype's **Configure** option to set the entry's own close date, submission limit (and period), closed message, and require login settings. Anything you leave blank falls back to the form's setting.

This way, your Summer Barbecue can stop taking RSVPs the day before the event, while the Winter Gala caps out at 200 guests — all from the same form.

#### In the Control Panel

Unique instances are woven through the Forms area of the Control Panel:

- The submissions listing gains an **Entry** column, and an **Entry** filter for narrowing the listing down to a single entry's submissions.
- When viewing a submission, a badge links back to the entry it was submitted from.
- Back on the entry's publish form, the Form fieldtype gets a **View Submissions** button, which opens that entry's submissions in a stack.

_TODO: Screenshot of the submissions listing with the Entry column and filter_

#### PHP API

You can tell whether a form has unique instances enabled with `$form->hasUniqueInstances()`. (It's always `false` when Forms Pro isn't installed.)

To work with a specific entry's instance, call `$form->instance($entryId)` to get a `Statamic\Forms\Instance`:

```php
$instance = $form->instance($entry->id());

$instance->status(); // "open", "closed", or "limit_reached"
$instance->restricted(); // Whether the instance is currently rejecting submissions.
$instance->restrictionMessage(); // The message to show, or null when open.
$instance->config('submission_limit'); // A setting, using the entry's override when there is one.
```

The form's own `status()`, `restricted()`, and `restrictionMessage()` methods delegate to the default instance — the form's behavior outside the context of any entry.

When [submitting forms programmatically](#submitting-forms-programmatically), pass the entry's ID to the `SubmitForm` action's `entry` method to submit to that entry's instance.

### Cloudflare Turnstile

Forms Pro can protect your forms from bots using [Cloudflare Turnstile](https://developers.cloudflare.com/turnstile/), Cloudflare's free CAPTCHA alternative.

Failed verifications are rejected with a normal validation error — nothing is saved, and the visitor is asked to try again.

#### Getting set up

First, create a widget in the [Cloudflare dashboard](https://dash.cloudflare.com/?to=/:account/turnstile) and grab its **Site Key** and **Secret Key**.

:::warning
If you're using Automagic Forms, that's all you need to do. Cloudflare Turnstile will "just work".
:::

Next, add the Turnstile tag to your form templates, wherever you'd like the widget to appear (usually just before the submit button):

::tabs

::tab antlers
```antlers
{{ form:contact }}
    ...

    {{ turnstile }}
    <button>Submit</button>
{{ /form:contact }}
```
::tab blade
```blade
<s:form:contact>
    ...

    <s:turnstile />
    <button>Submit</button>
</s:form:contact>
```
::

Make sure Forms Pro's frontend JavaScript is loaded. It takes care of loading Cloudflare's API, rendering the widget, and disabling the submit button until the visitor has been verified:

```bash
php artisan vendor:publish --tag=forms-pro-frontend
```

```html
<script src="/vendor/forms-pro/frontend/js/forms-pro.js"></script>
```

Finally, add both keys to your `.env`:

```env
FORMS_PRO_TURNSTILE_SITE_KEY=your-site-key
FORMS_PRO_TURNSTILE_SECRET_KEY=your-secret-key
```

:::warning
Once both keys are set, Forms Pro will require all form submissions to have a valid Turnstile token, otherwise validation will fail. You should add the Turnstile tag anywhere you render a form.
:::

#### Widget appearance

Whether visitors see a checkbox, a spinner, or nothing at all isn't something Forms Pro controls — it depends on the **Widget Mode** (Managed, Non-Interactive, or Invisible) you chose when creating the widget in the Cloudflare dashboard.

[Automagic Forms](#automagic-forms) are protected automatically — the widget appears on every form page without any template changes.

#### Multi-page forms

On [multi-page forms](#multi-page-forms), Turnstile only verifies the visitor once, when the final page is submitted. How the widget behaves before then depends on how your form is rendered:

- **Without a JavaScript driver**, the tag renders nothing on intermediate pages — a submission can only be finalized from the final page, so that's the only place the widget appears. You can safely output the tag on every page.
- **With the Alpine drivers**, the widget renders once and sticks around for the whole form. Intermediate pages are submitted over AJAX, so they're never held back — only the final submission waits for verification.

:::tip
When using the Alpine drivers, output the Turnstile tag *outside* the `{{ pages }}` loop. The widget is wired up on page load, so it won't work inside a page's `<template x-if>` block. If you'd rather it only appeared on the last page, hide it with `x-show="formsPro.isFinalPage"` instead.
:::
