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
- `email_config` - The email's config
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

use App\Http\Controllers\AcmeConnectionController;
use Statamic\Contracts\Forms\Form;
use Statamic\Forms\Connections\Connection;
use Statamic\Support\VueComponent;

class Acme extends Connection
{
    protected static $title = 'Acme';
    protected $description = 'Send submissions to Acme.';
    protected $icon = 'globe-arrow';

    public function count(Form $form): ?int
    {
        return count($form->connections()->get('acme', []));
    }

    public function render(Form $form): VueComponent
    {
        return VueComponent::render('acme-connection', [
            'action' => cp_route('forms.connect.acme.update', $form->handle()),
            'config' => $form->connections()->get('acme', []),
        ]);
    }

    public function routes($router): void
    {
        $router->patch('/', [AcmeConnectionController::class, 'update'])->name('update');
    }
}
```

#### Properties & Methods

| Property/Method | Description |
| --- | --- |
| `$title` | The title shown on the Connect index. Defaults to a title generated from the class name. |
| `$description` | A short description shown on the Connect index. |
| `$icon` | The icon shown on the Connect index. |
| `count()` | The number shown in the "Connections" badge on the Connect index. Optional. |
| `render()` | The Vue component (and its props) rendered on the connection's page. |
| `routes()` | Routes for the connection, like the one your component saves to. They're registered under `/forms/{form}/connect/{handle}` and automatically wrapped in authorization. |
| `finalized()` | The job (or array of jobs) to be dispatched when a submission is finalized. |

#### The frontend

The `render()` method determines which Vue component gets rendered, along with its props.

Connections handle their own saving — your component should post back to a route you've registered in the `routes()` method.

If your connection supports multiple "rows" (eg. multiple emails per form), you can use the `<ConnectionList>` component to get a head start.

Pass it your array of configs via `v-model`, a header slot and a body slot for each row, and it takes care of the collapsible row UI, along with the add/duplicate/remove actions.

```vue
<script setup>
import { ref } from 'vue';
import { nanoid as uniqid } from 'nanoid';
import { ConnectionList } from '@statamic/cms';
import { Badge } from '@statamic/cms/ui';

const props = defineProps({ config: Array });

const notifications = ref([...props.config]);

const addNotification = () => notifications.value.push({ id: uniqid(), conditions: [] });
const duplicateNotification = (notification) => notifications.value.push({ ...notification, id: uniqid() });
const removeNotification = (notification) => (notifications.value = notifications.value.filter((item) => item !== notification));
</script>

<template>
    <ConnectionList
        v-model="notifications"
        :add-label="__('Add Notification')"
        @add="addNotification"
        @duplicate="duplicateNotification"
        @remove="removeNotification"
    >
        <template #header="{ item: notification, collapsed }">
            <Badge size="lg" pill>{{ notification.channel || __('New Notification') }}</Badge>
        </template>

        <template #default="{ item: notification, index }">
            <!-- Each row's fields go here... -->
        </template>
    </ConnectionList>
</template>
```

#### Conditional logic

If you want your connection to support conditional logic, the `<ConnectionLogic>` component renders the logic builder. Bind your conditions with `v-model:conditions` and put whatever the conditions control inside its `then` slot.

```vue
<template #default="{ item: notification, index }">
    <ConnectionLogic
        v-model:conditions="notification.conditions"
        :always-label="__('Always send')"
        :if-label="__('Send if...')"
    >
        <template #then>
            <!-- The fields controlled by the conditions go here... -->
        </template>
    </ConnectionLogic>
</template>
```

On the PHP side, the `Statamic\Forms\Connections\ConnectionLogic` class handles the rest:

- When saving, `ConnectionLogic::normalize($conditions)` strips out any incomplete conditions, and returns `null` when there's nothing to save.
- When a submission comes in, `ConnectionLogic::passes($config, $submission)` evaluates the conditions against the submission, so you can decide whether to send anything or not.

#### Sending notifications

When a submission is finalized, Statamic dispatches a single job chain: file uploads are converted to assets, then each of the connection jobs run and finally temporary file uploads are deleted.

To hook into this process, return a job (or array of jobs) from the `finalized()` method:

```php
public function finalized($submission)
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

## Localizing forms

Form fields aren't yet localizable — a field's display label, instructions, and options are shared across every site. We're planning on adding support for this soon.

In the meantime, you have a couple of options if you need a form's labels translated per site:

- Use the [Translation Manager](https://statamic.com/addons/thoughtco/translation-manager) addon by Thought Collective, which lets you manage translations for content that isn't otherwise localizable.
- Duplicate the form once per site, and translate its labels, instructions, and options by hand.

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
- Unique form instances per entry
- Additional fieldtypes & connections
- Enhanced spam prevention

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

[submissions]: /tags/form-submissions
