---
id: ecf1c18e-cdc6-4120-b19a-af1c3851ea53
blueprint: page
title: Forms Pro
template: page
intro: 'Build polished multi-page experiences, publish branded forms without creating a template, explore responses with charts and insights, and send submissions directly to the tools you already use.'
related_entries:
  - fdb45b84-3568-437d-84f7-e3c93b6da3e6
---

[Forms Pro](https://statamic.com/addons/statamic/forms-pro) turns forms into complete experiences and workflows — not just places to collect a name and email address.

- **Launch without building a page.** [Automagic Forms](#automagic-forms) gives every form its own branded, shareable URL.
- **Make long forms feel manageable.** Split them into [multiple pages](#multi-page-forms) and guide visitors down different paths based on their answers.
- **See what people are telling you.** Turn responses into customizable [charts and insights](#form-summaries) inside the Control Panel.
- **Put submissions to work.** Send them directly to [Google Sheets, HubSpot, Mailchimp, Slack, and more](#connections).
- **Reuse one form across many entries.** Give every event, listing, or entry [its own submissions, limits, and notifications](#unique-instances).
- **Collect better data.** Add [address autocomplete](#address-fieldtype), additional fieldtypes, and [Cloudflare Turnstile](#cloudflare-turnstile) protection.

You can try every Forms Pro feature locally for free. When you're ready, installation takes two commands.

## Installation

1. Install the Forms Pro add-on via Composer:

   ```bash
   composer require statamic/forms-pro
   ```

2. Publish the configuration file to `config/forms-pro.php`:

   ```bash
   php artisan vendor:publish --tag=forms-pro-config
   ```

That's it. Forms Pro's features are now ready and waiting in the Control Panel.

## Connections

Alongside the Email and Webhook connections that ship with Statamic, Forms Pro adds connections for a number of third-party services. You'll find them in the same **Connect** area of your form.

When you set each one up, it'll guide you through getting everything connected.

_TODO: Screenshot of the Connect area showing the Forms Pro connections_

### Google Sheets

Adds submissions as rows in a [Google Sheet](https://workspace.google.com/products/sheets/). You paste the spreadsheet's address, choose a tab, and pick which fields become columns — or leave that empty to include everything.

Rows are added to the bottom, so your existing rows are left alone. Columns are named after field handles, and appear the first time a field is submitted.

### HubSpot

Sends submissions to a form in your [HubSpot](https://www.hubspot.com) account, so any workflows and follow-up emails attached to that form run as normal.

You choose which of the HubSpot form's properties to map to your fields, and if it collects GDPR consent, you can map those options too.

If you've added HubSpot's tracking code to your site, submissions will be linked to the visitor's browsing history. You'll want to turn off "Collect data from website forms" in HubSpot, otherwise it'll record its own copy of every submission.

### Kit

Subscribes people to your [Kit](https://kit.com) account. You can map custom fields and apply tags to subscribers — they'll need to exist in Kit first so you can pick them.

Subscribers can also be attributed to a Kit form, so any automations linked to it will run.

### Mailchimp

Subscribes people to a [Mailchimp](https://mailchimp.com) audience. You can apply tags, map fields to the audience's merge fields, add people to groups based on what they chose, and record GDPR marketing permissions against the contact.

New subscribers are added as pending until they confirm by email, unless you turn on "Skip Confirmation Email".

### Mailcoach

Subscribes people to a [Mailcoach](https://www.mailcoach.app) email list. You can apply tags and store extra values as attributes.

For lists using double opt-in, "Skip Confirmation Email" subscribes people immediately rather than asking them to confirm.

### Slack

Posts submissions to a [Slack](https://slack.com) channel, with a button linking through to the submission in the Control Panel. You can write your own heading and choose which fields to include.

### Twilio

Sends a text message via [Twilio](https://www.twilio.com) when the form is submitted. Text a fixed number, or pick a form field to text whoever submitted. The message body can include values from the submission.

## Address fieldtype

Forms Pro ships an **Address** fieldtype with localized field labels and autocomplete powered by [Google Places](https://developers.google.com/maps/documentation/places/web-service/place-autocomplete) or [Geoapify](https://www.geoapify.com/).

### Localization

Address formats differ by country, so the field adapts itself to country changes:

- The "Region" label becomes "State", "Province", "County", "Prefecture", and so on. It's hidden entirely for countries that don't use one.
- The "Postcode" label becomes "ZIP Code", "Postal Code", "Eircode", and so on. It's likewise hidden where it doesn't apply.
- Some countries (the US, Canada, China, and Italy) require a region, so it's marked as required even when the field as a whole is optional.

You can set a **Default Country** in the field's configuration to control which country — and therefore which labels — are shown by default.

### Autocomplete

To enable autocomplete, specify a provider and publishable API key in your `.env`:

```env
FORMS_PRO_ADDRESS_AUTOCOMPLETE_PROVIDER=google # or: geoapify
FORMS_PRO_ADDRESS_AUTOCOMPLETE_KEY=your-key
```

Typing into the "Line 1" field suggests addresses; picking one fills in the rest of the fields. Forms Pro supports two autocomplete providers:

- **Google Places** — the best data, and the only provider that returns unit numbers, handles UK postal towns, and per-country administrative levels. A billing account (payment method) is required to obtain an API key.
- **Geoapify** — free up to 3,000 requests per day. It doesn't have the concept of a "subpremise" — the sub-unit of a building, like a flat number in the UK — so it won't fill in Line 2.

### Customizing the front-end

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

#### Autocomplete markup

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

## Multi-page forms

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

### Controlling page logic

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

### Customizing page buttons

Page buttons default to “Next” and “Previous” but you can customize them to say whatever you want. Tease your users with something informative or cheeky—“Let's find out what Star Sign you are!”, “Ready to find out your perfect career?”, “Which Ninja Turtle are you?”, etc.

<figure>
  <img src="/img/forms-pro/customize-button-text.webp" alt="Customize button text for Forms Pro" class="u-hide-in-dark-mode">
  <img src="/img/forms-pro/customize-button-text-dark.webp" alt="Customize button text for Forms Pro" class="u-hide-in-light-mode">
  <figcaption>Customize button text for Forms Pro</figcaption>
</figure>

### Templating
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

### Submitting with JavaScript
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

#### State

| Property               | Description                                                    |
|------------------------|----------------------------------------------------------------|
| `formsPro.currentPage` | Handle of the page currently being shown.                      |
| `formsPro.pages`       | Array of all pages.                                            |
| `formsPro.errors`      | Validation errors for the current page, keyed by field handle. |
| `formsPro.submitting`  | `true` while a page is being submitted over AJAX.              |
| `formsPro.visited`     | Handles of the pages visited so far.                           |

#### Getters

| Property               | Description                            |
|------------------------|----------------------------------------|
| `formsPro.page`        | The current page object.               |
| `formsPro.pageIndex`   | Zero-based index of the current page.  |
| `formsPro.isFirstPage` | Whether the current page is the first. |
| `formsPro.isFinalPage` | Whether the current page is the last.  |

#### Methods

| Method                        | Description                                                                       |
|-------------------------------|-----------------------------------------------------------------------------------|
| `formsPro.submit($event)`     | Submit the current page over AJAX and advance to the next.                        |
| `formsPro.goToPage(pageId)`   | Jump to a previously visited page. Forward jumps and unvisited pages are ignored. |
| `formsPro.goToPreviousPage()` | Go back to the previous page.                                                     |
| `formsPro.goToFirstPage()`    | Jump back to the first page.                                                      |

All methods are namespaced under `formsPro` to avoid conflicts with your own Alpine data. This means that methods need to be called with `()` — bare references like `@click="formsPro.submit"` won't bind correctly.

### Building your own driver
While the Alpine drivers are the easiest way to get started, you can also build your own driver.

Statamic's [custom JS drivers](https://statamic.dev/tags/form-create#custom-js-drivers) documentation covers how a driver is built and registered; this section covers what a driver needs to do to support multi-page forms specifically.

A page-aware driver has two responsibilities: **tracking the active page**, and **submitting intermediate pages over AJAX**.

#### Tracking page state
Render every page up-front (using the `{{ pages }}` loop), then only show the current page to the visitor. At a minimum, you'll want to keep track of:

- the current page
- the pages the visitor has already visited (so you can offer a "previous" button)
- the validation errors for the current page

The `{{ form:create }}` tag outputs a hidden `_page` input with the current page's ID. You should keep this up to date as the visitor moves between pages.

#### Submitting a page

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

### Logic

By default, submitting a page takes the visitor to the next page in sequence. However, **logic** can be used to skip pages, or branch out to different pages based on the answers they provide.

Logic can be configured in the **Form Builder**, under the "Logic" tab when inspecting a page. Pages can have multiple rules, and each rule can have multiple conditions, paired with a destination (the page to jump to when those conditions are met). You can also manage logic from the "Logic" page in the Control Panel.

When a page is submitted, its rules are evaulated in order. The first rule whose conditions pass wins, and the visitor is taken to its destination. If no rule matches, they continue to the next page in sequence. When there's nowhere left to go, the submission is finalized.

Unlike field logic, page logic is evaluated on the server, so logic behaves identically whether you're using plain POSTs or one of the JS drivers.

#### Combining conditions with _and_ / _or_

Every condition is joined to the previous one with **and** or **or**. Conditions are grouped so that **and** binds more tightly than **or**: a new group begins at each **or**, a group passes when _all_ of its conditions pass, and the rule passes when _any_ group passes.

Confused? Here's a visual example:

> `country` is `United States` **and** `state` is `California`
> **or** `country` is `Canada`

...is evaluated as `(country is United States and state is California) or (country is Canada)`.

## Form summaries

Forms Pro lets you view a summary of your form responses without needing to export submissions.

This is useful for spotting trends in your responses. See how many people signed up to your newsletter, or find out whether Robert Smith fans are also secretly listening to Olivia Rodrigo.

<figure>
  <img src="/img/forms-pro/form-summaries.webp" alt="A summary of form responses the control panel, showing various graph types and questions" class="u-hide-in-dark-mode">
  <img src="/img/forms-pro/form-summaries-dark.webp" alt="A summary of form responses the control panel, showing various graph types and questions" class="u-hide-in-light-mode">
  <figcaption>View a summary of form responses without leaving the control panel</figcaption>
</figure>

You'll find the summary behind a toggle at the top of the [submissions listing](/frontend/forms#viewing-submissions). Each of your form's questions gets its own chart, and any filters or search you apply to the listing narrow the summary too — handy for summarizing just this month's responses, or just the ones that mention "racoon".

A few other things worth knowing:

- The toggle in the top-left switches every chart between percentages and response counts.
- Some fieldtypes show **insights** alongside their chart — small stat badges like the average, the minimum & maximum, or how many people checked a toggle.
- Your submissions/summary and percentage/count choices are remembered between visits.

### Charts

Each fieldtype comes with a sensible default chart:

| Chart | Used by default for |
| --- | --- |
| Pie chart | Multiple Choice |
| Bar chart | Checkboxes, Dropdown, Image Choice, Yes/No, Toggle, Star Rating, and free-text fields like Short Answer and Email |
| Column chart | Number, Currency, Opinion Scale |
| Lollipop chart | Dictionary |
| Ranking | Ranking |

Free-text fields chart their most popular answers, and numeric answers are automatically grouped into ranges when there are too many distinct values to plot individually.

Charts cap how many items they show — four segments in a pie chart, five rows in a bar or lollipop chart. The least popular answers beyond that are grouped into an **Other** item, and on pie charts you can click the Other segment to drill into a breakdown of what's inside it.

Date, Time, Name and Upload fields aren't charted.

### Customizing the charts

If you can edit the form, you'll see a **Customize Charts** button in the summary. While customizing, you can:

- **Add Chart** to chart a field that isn't in the summary yet.
- Drag charts around to reorder them.
- Switch a chart's type using the dropdown on each chart. Any chart type can be used with any field — pie chart your star ratings, we won't judge.
- Remove charts you don't need.

Hit **Save** and the layout is saved to the form itself, so everyone sees the same summary.

### Building custom charts

You can build your own chart types too. Create a class in the `app/FormCharts` directory that extends `Statamic\Forms\Charts\Chart` and Statamic will discover it automatically. Addons can do the same in their `FormCharts` directory, or register classes explicitly using the `$formCharts` property on their service provider.

```php
<?php

namespace App\FormCharts;

use Statamic\Forms\Charts\Chart;

class Doughnut extends Chart
{
    protected static $title = 'Doughnut chart';

    protected ?string $component = 'doughnut-chart';
    protected ?string $icon = 'chart-doughnut';
    protected ?int $limit = 4;
}
```

| Property/Method | Description |
| --- | --- |
| `$title` | The name shown when picking a chart type. Defaults to a title generated from the class name. |
| `$component` | The Vue component used to render the chart. |
| `$icon` | The icon shown when picking a chart type. |
| `$limit` | The maximum number of items to show before the rest are grouped into "Other". Optional. |
| `props()` | The props passed to the Vue component. |
| `drilldownProps()` | The props the chart re-renders with when drilling into its "Other" items. Returning an empty array (the default) means the chart doesn't drill down. |

You don't usually need to touch `props()` — the base class counts the answers against the field's [chart options](#charting-your-own-fieldtypes) (or derives options from the answers themselves), and handles the "Other" grouping for you. Each item it produces has a `key`, `label`, `count` and `percent`.

On the frontend, register the Vue component in your JS entry file (`resources/js/cp.js`):

```js
import DoughnutChart from './components/charts/DoughnutChart.vue';

Statamic.booting(() => {
    Statamic.$components.register('doughnut-chart', DoughnutChart);
});
```

Your component receives whatever `props()` returns, along with two extras: `metric` (either `percent` or `count`, following the toggle at the top of the summary) and `accessibleLabel` (a screen-reader-friendly rundown of the results). It's also handed a `summary` slot containing the field's [insights](#building-custom-insights) — render it if you'd like them to appear inside your chart.

```vue
<script setup>
defineProps({
    items: { type: Array, default: () => [] },
    metric: { type: String, default: 'percent' },
    accessibleLabel: String,
});
</script>

<template>
    <div role="img" :aria-label="accessibleLabel">
        <slot name="summary" />
        <div v-for="item in items" :key="item.key">
            {{ item.label }}: {{ metric === 'count' ? item.count : `${item.percent}%` }}
        </div>
    </div>
</template>
```

:::tip
The chart components Statamic itself uses — `PieChart`, `HorizontalBarChart`, `VerticalBarChart` and `HorizontalLollipopChart` — are available from `@statamic/cms/ui` if you'd rather build on top of them.
:::

### Building custom insights

Insights are the small stat badges shown alongside a field's chart. Statamic ships with `Average`, `MinMax`, `Checked` and `StarRating` insights, and you can build your own.

Create a class in the `app/FormInsights` directory that extends `Statamic\Forms\Insights\Insight` and Statamic will discover it automatically. Addons can do the same in their `FormInsights` directory, or register classes explicitly using the `$formInsights` property on their service provider.

```php
<?php

namespace App\FormInsights;

use Illuminate\Support\Collection;
use Statamic\Forms\Insights\Insight;

class Median extends Insight
{
    public function props(Collection $values): array
    {
        $values = $values->filter(fn ($value) => is_numeric($value))->sort()->values();

        return ['median' => $values->get(intdiv($values->count(), 2)) ?? 0];
    }
}
```

The `props()` method receives every answer to the field and returns the props for the insight's Vue component. The component is named after the class by default — `median-insight` for the class above — but you can override that with a `$component` property. Register it the same way as a chart component:

```js
import MedianInsight from './components/insights/MedianInsight.vue';

Statamic.booting(() => {
    Statamic.$components.register('median-insight', MedianInsight);
});
```

Unlike charts, insights aren't picked in the Control Panel — fieldtypes attach them with their `insights()` method, which you'll read about next.

### Charting your own fieldtypes

[Custom form fieldtypes](/fieldtypes/build-a-form-fieldtype) opt into the summary using three methods:

| Method | Description |
| --- | --- |
| `defaultChart()` | The class name of the chart the field uses by default. Returning `null` (the default) keeps the field out of the summary. |
| `chartOptions()` | The full set of options answers are counted against, in the order they should be charted. Returning `null` (the default) derives the options from the answers themselves. |
| `insights()` | An array of insight instances to show alongside the chart. |

```php
use Illuminate\Support\Collection;
use Statamic\Forms\Charts\ChartOption;
use Statamic\Forms\Charts\VerticalBar;
use Statamic\Forms\Insights\Average;

public function defaultChart(): ?string
{
    return VerticalBar::class;
}

public function chartOptions(Collection $values): ?Collection
{
    return collect(range($this->config('min'), $this->config('max')))
        ->map(fn ($value) => new ChartOption((string) $value));
}

public function insights(): array
{
    return [new Average];
}
```

Returning options from `chartOptions()` means every option is charted — even the ones nobody picked — in the order you choose. Each `ChartOption` takes a `key` (matching the stored answer), an optional `label`, and an optional `icon`, `image` or `badge` to display alongside it.

## Automagic Forms

Sometimes you don't want to build a page for a form at all. **Automagic Forms** gives every form its own hosted, shareable page — no template or entry required. It's positioned similarly to Google Forms or Typeform's form pages, so non-technical clients can build and share a form without switching to another system.

Form pages support your own branding, multi-page navigation, a progress bar, real-time validation, and file uploads.

### Enabling it on a form

Each form has an **Automagic Forms** section in its configuration. Flip the **Enable Automagic Form** toggle and the form goes live at its own shareable URL.

Once enabled, you can:

- Copy the **Automagic Form URL** and share it with anyone you'd like to fill it out.
- Customize the **Success Heading** and **Success Message** shown after a visitor submits.
- Turn on **Let visitors fill out the form again?** to show a button on the confirmation page for starting a new submission, with a customizable **Fill out again button label**.

### The form's URL

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

### Branding

You can customize the look and feel of your Automagic Forms from **Addons → Forms Pro** in the Control Panel:

- **Logo** — shown in the top-left corner of every Automagic Form. The asset container it's picked from can be set via `asset_container` in `config/forms-pro.php`; it defaults to your first container.
- **Brand Color** — overrides the color used for buttons and the progress bar. Leave it blank to use the default colors.
- **Background** — the background pattern shown behind every Automagic Form, picked from Steve Schoger's [Heropatterns](https://heropatterns.com/).

### Disabling Automagic Forms

Automagic Forms are enabled by default. If you'd rather disable them entirely, turn them off in `config/forms-pro.php`:

```php
'automagic_forms' => [
    'enabled' => false,
    // ...
],
```

## Unique Instances

Sometimes one form needs to act like many. Picture an Events collection where every event has its own RSVP form — you don't want one big pile of RSVPs, you want to know who's coming to _which_ event, close registrations per event, and cap the numbers per event.

Rather than duplicating the form for every entry, **Unique Instances** lets a single form be shared across your entries, with each entry treated as its own instance. Submissions are attached to the entry they were submitted from, and [restrictions](/frontend/forms#restricting-submissions) like close dates and submission limits apply per entry — with the option to override them per entry too.

### Enabling it on a form

On the form's configure screen, under **Submissions**, flip the **Unique Instances** toggle. (You'll only see it when Forms Pro is installed.)

### Attaching the form to entries

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

### Submissions

Each submission stores the ID of the entry it was submitted from. The `entry` value is augmented into the entry itself, so you can use its variables when [displaying submission data](/frontend/forms#displaying-submission-data):

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

### Per-entry restrictions

When unique instances is enabled, [submission restrictions](/frontend/forms#restricting-submissions) are checked against the entry being submitted from. A submission limit of 100 means 100 submissions _per event_, not 100 across the whole form. The same goes for close dates, closed messages, and requiring login — and the `restricted`, `restriction_message`, and `status` variables on the `{{ form:create }}` tag reflect the current entry's instance, so your existing template handles it all.

The form's own **Access** settings act as defaults, and each entry can override them. On the entry's publish form, use the Form fieldtype's **Configure** option to set the entry's own close date, submission limit (and period), closed message, and require login settings. Anything you leave blank falls back to the form's setting.

This way, your Summer Barbecue can stop taking RSVPs the day before the event, while the Winter Gala caps out at 200 guests — all from the same form.

### Per-entry connections

Each entry can also override the form's [connections](/frontend/forms#connections) — so the Winter Gala's confirmation email can go out from a different address than the Summer Barbecue's, without touching the form itself.

From the same **Configure** option, open the **Connections** field to browse the form's connection types. Click one to edit it for this entry alone, using the same editor you'd see on the form's own [Connect](/frontend/forms#connections) page. Applying an edit doesn't save it to the form — it's stored against the entry, and used instead of the form's connections whenever this entry's instance sends notifications. Leave a connection type alone and the entry keeps following the form's own configuration for it.

### In the Control Panel

Unique instances are woven through the Forms area of the Control Panel:

- The submissions listing gains an **Entry** column, and an **Entry** filter for narrowing the listing down to a single entry's submissions.
- When viewing a submission, a badge links back to the entry it was submitted from.
- Back on the entry's publish form, the Form fieldtype gets a **View Submissions** button, which opens that entry's submissions in a stack.

_TODO: Screenshot of the submissions listing with the Entry column and filter_

### PHP API

You can tell whether a form has unique instances enabled with `$form->hasUniqueInstances()`. (It's always `false` when Forms Pro isn't installed.)

To work with a specific entry's instance, call `$form->instance($entryId)` to get a `Statamic\Forms\Instance`:

```php
$instance = $form->instance($entry->id());

$instance->status(); // "open", "closed", or "limit_reached"
$instance->restricted(); // Whether the instance is currently rejecting submissions.
$instance->restrictionMessage(); // The message to show, or null when open.
$instance->config('submission_limit'); // A setting, using the entry's override when there is one.
$instance->connections(); // The connections to run — the entry's override when there is one, otherwise the form's own.
```

The form's own `status()`, `restricted()`, and `restrictionMessage()` methods delegate to the default instance — the form's behavior outside the context of any entry.

When [submitting forms programmatically](/frontend/forms#submitting-forms-programmatically), pass the entry's ID to the `SubmitForm` action's `entry` method to submit to that entry's instance.

## Cloudflare Turnstile

Forms Pro can protect your forms from bots using [Cloudflare Turnstile](https://developers.cloudflare.com/turnstile/), Cloudflare's free CAPTCHA alternative.

Failed verifications are rejected with a normal validation error — nothing is saved, and the visitor is asked to try again.

### Getting set up

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

### Widget appearance

Whether visitors see a checkbox, a spinner, or nothing at all isn't something Forms Pro controls — it depends on the **Widget Mode** (Managed, Non-Interactive, or Invisible) you chose when creating the widget in the Cloudflare dashboard.

[Automagic Forms](#automagic-forms) are protected automatically — the widget appears on every form page without any template changes.

### Multi-page forms

On [multi-page forms](#multi-page-forms), Turnstile only verifies the visitor once, when the final page is submitted. How the widget behaves before then depends on how your form is rendered:

- **Without a JavaScript driver**, the tag renders nothing on intermediate pages — a submission can only be finalized from the final page, so that's the only place the widget appears. You can safely output the tag on every page.
- **With the Alpine drivers**, the widget renders once and sticks around for the whole form. Intermediate pages are submitted over AJAX, so they're never held back — only the final submission waits for verification.

:::tip
When using the Alpine drivers, output the Turnstile tag *outside* the `{{ pages }}` loop. The widget is wired up on page load, so it won't work inside a page's `<template x-if>` block. If you'd rather it only appeared on the last page, hide it with `x-show="formsPro.isFinalPage"` instead.
:::
