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
- **Collect better data.** Add [address autocomplete](#address-fieldtype) and additional fieldtypes.

You can try every Forms Pro feature locally for free. When you're ready, installation takes two commands.

## Installation

1. Install the Forms Pro add-on via Composer:

   ```bash
   composer require statamic/forms-pro
   ```

2. Publish the configuration file to `config/statamic/forms-pro.php`:

   ```bash
   php artisan vendor:publish --tag=forms-pro-config
   ```

That's it. Forms Pro's features are now ready and waiting in the Control Panel.

## Connections

Alongside the Email and Webhook connections that ship with Statamic, Forms Pro adds connections for a number of third-party services. You'll find them in the same **Connect** area of your form.

When you set each one up, it'll guide you through getting everything connected.

<figure>
  <img src="/img/forms-pro/connect-area.webp" alt="Statamic's form connect area" class="u-hide-in-dark-mode">
  <img src="/img/forms-pro/connect-area-dark.webp" alt="Statamic's form connect area" class="u-hide-in-light-mode">
  <figcaption>The Connect area</figcaption>
</figure>

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

- The "State / Province / Region" label becomes "State", "Province", "County", "Prefecture", and so on. It's hidden entirely for countries that don't use one.
- The "Postal Code" label becomes "ZIP Code", "Postcode", "Eircode", and so on. It's likewise hidden where it doesn't apply.
- Some countries (the US, Canada, Australia, India, Japan, Brazil, China, Italy, and the UAE) require a region, so it's marked as required even when the field as a whole is optional. This is only enforced in the browser.

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
    <ul>
        <li data-address-option><span data-address-label></span></li>
        <li data-address-attribution></li>
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
While a visitor moves through the pages, their partial submission only dispatches the `SubmissionSaving` and `SubmissionSaved` events. `SubmissionCreating`, `SubmissionCreated` and [`SubmissionFinalized`](/backend-apis/events#submissionfinalized) are dispatched once the final page is submitted.

If you're listening to `SubmissionSaving` or `SubmissionSaved` and _don't_ want to receive incomplete submissions, listen to [`SubmissionFinalized`](/backend-apis/events#submissionfinalized) instead.
:::

Partial submissions are stored between pages even when the form's **Store Submissions** setting is off, and deleted once the final page is submitted. Abandoned ones are cleaned up by a scheduled job, so make sure the scheduler is running. See [Storing submissions](/frontend/forms#storing-submissions) for details.

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

Page buttons default to “Next” (or “Submit” on the last page) but you can customize them to say whatever you want. You can also turn on a “Previous Page” button for every page after the first, and change its label too. Tease your users with something informative or cheeky—“Let's find out what Star Sign you are!”, “Ready to find out your perfect career?”, “Which Ninja Turtle are you?”, etc.

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

| Variable                   | Description                                                                                     |
|----------------------------|-------------------------------------------------------------------------------------------------|
| `form_page:display`        | The page's display name.                                                                        |
| `form_page:instructions`   | The page's help text.                                                                           |
| `form_button_label`        | Label for the submit button.                                                                    |
| `form_previous_page_url`   | URL to navigate back to the previous page. Not available on the first page.                     |
| `form_previous_page_label` | Label for the "previous page" link. Only set when the page's Previous Page button is turned on. |

Apart from wiring up button labels and a link back to the previous page, you can use an existing template as-is:

```antlers
{{ form:survey }}
    {{ if success }}
        <p>Success!</p>
    {{ /if }}

    <h2>{{ form_page:display }}</h2>
    <p>{{ form_page:instructions }}</p>

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

    {{ if form_previous_page_label }}
        <a href="{{ form_previous_page_url }}">{{ form_previous_page_label }}</a>
    {{ /if }}

    <button>{{ form_button_label }}</button>
{{ /form:survey }}
```

:::warning
When moving between pages, fields are pre-populated from the visitor's partial submission.
If you're using [static caching](/static-caching), you should wrap your forms in the [`{{ nocache }}`](/tags/nocache) tag to prevent submitted data from being cached.
:::

### Submitting with JavaScript
Out of box, every page is submitted with a native `<form>` POST, incurring a full page reload.

Forms Pro ships with two Alpine JS drivers — `forms_pro_alpine` and `forms_pro_alpine_precognition` — that manage page state on the frontend and submit intermediate pages over AJAX, letting your visitors move between pages without a full page reload. They build on Statamic's [core Alpine drivers](/tags/form-create#logic-conditional-fields).

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

Next, loop through `{{ form_pages }}` and wrap each page in `<template x-if="{{ show_page }}">`. Make sure anything page-related (like the page's display name and button labels) is _inside_ the loop and without the `form_page:` and `form_` prefixes.

Also, add click handler to the previous/next buttons to call `formsPro.goToPreviousPage()` and `formsPro.submit($event)` respectively.

```antlers
{{ form:survey js="forms_pro_alpine" }}
   {{-- ... --}}

   {{ form_pages }}
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
   {{ /form_pages }}

   {{-- ... --}}
{{ /form:survey }}
```

Finally, render validation errors for each field using `formsPro.errors['{{ handle }}']` in addition to your existing error handling. Forms Pro's error handling will be used for intermediate pages, but you'll need to display errors for the final page separately.

```antlers
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

Statamic's [custom JS drivers](/tags/form-create#custom-js-drivers) documentation covers how a driver is built and registered; this section covers what a driver needs to do to support multi-page forms specifically.

A page-aware driver has two responsibilities: **tracking the active page**, and **submitting intermediate pages over AJAX**.

#### Tracking page state
Render every page up-front (using the `{{ form_pages }}` loop), then only show the current page to the visitor. At a minimum, you'll want to keep track of:

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
| Bar chart | Checkboxes, Dropdown, Image Choice, Yes/No, Toggle, Star Rating |
| Column chart | Number, Currency, Opinion Scale |
| Lollipop chart | Dictionary |
| Ranking | Ranking |

Numeric answers are automatically grouped into ranges when there are too many distinct values to plot individually.

Charts cap how many items they show — four segments in a pie chart, five rows in a bar or lollipop chart, twelve columns in a column chart. The least popular answers beyond that are grouped into an **Other** item, and you can drill into a breakdown of what's inside it.

Free-text fields (Short Answer, Long Answer, Email, Name, Phone, Website), Date, Time and Upload fields aren't charted.

### Customizing the charts

If you can edit the form, you'll see a **Customize Charts** button in the summary. While customizing, you can:

- **Add Chart** to chart a field that isn't in the summary yet.
- Drag charts around to reorder them.
- Switch a chart's type using the dropdown on each chart. You'll be offered every chart type that suits the field's answers — pie chart your star ratings, we won't judge.
- Remove charts you don't need.

Hit **Save** and the layout is saved to the form itself, so everyone sees the same summary.

### Building custom charts

You can build your own chart types too. Create a class in the `app/FormCharts` directory that extends `Statamic\Forms\Charts\Chart` and Statamic will discover it automatically. Addons can do the same in their `FormCharts` directory, or register classes explicitly using the `$formCharts` property on their service provider.

```php
<?php

namespace App\FormCharts;

use Statamic\Forms\Charts\Chart;
use Statamic\Forms\Fields\FormValueType;

class Doughnut extends Chart
{
    protected static $title = 'Doughnut chart';

    protected ?string $component = 'doughnut-chart';
    protected ?string $icon = 'chart-doughnut';
    protected ?int $limit = 4;

    public function supports(): array
    {
        return [FormValueType::Number, FormValueType::Boolean, FormValueType::Choice];
    }
}
```

| Property/Method | Description |
| --- | --- |
| `$title` | The name shown when picking a chart type. Defaults to a title generated from the class name. |
| `$component` | The Vue component used to render the chart. |
| `$icon` | The icon shown when picking a chart type. |
| `$limit` | The maximum number of items to show before the rest are grouped into "Other". Optional. |
| `supports()` | Required. The kinds of answers the chart can display, as an array of `FormValueType` cases (`Number`, `Boolean`, `Choice`, `Choices` or `Ranking`). The chart is only offered for fields whose [value type](#charting-your-own-fieldtypes) is in this list. |
| `props(FieldResponses $responses, ?Collection $options = null)` | The props passed to the Vue component. |

You don't usually need to touch `props()` — the base class counts the answers against the field's [chart options](#charting-your-own-fieldtypes) (or derives options from the answers themselves), and handles the "Other" grouping for you. Each item it produces has a `key`, `label`, `count` and `percent`. When answers are grouped into "Other", it also adds a `drilldown` prop, which the summary uses to show a breakdown of what's inside it.

On the frontend, register the Vue component in your JS entry file (`resources/js/cp.js`):

```js
import DoughnutChart from './components/charts/DoughnutChart.vue';

Statamic.booting(() => {
    Statamic.$components.register('doughnut-chart', DoughnutChart);
});
```

Your component receives whatever `props()` returns, along with a few extras: `metric` (either `percent` or `count`, following the toggle at the top of the summary), `responses` (the number of responses), and `accessibleLabel` (a screen-reader-friendly rundown of the results). When answers are grouped into "Other", that item has `clickable: true`. Emit a `select` event when it's clicked to show the breakdown.

```vue
<script setup>
defineProps({
    items: { type: Array, default: () => [] },
    metric: { type: String, default: 'percent' },
    accessibleLabel: String,
});

const emit = defineEmits(['select']);
</script>

<template>
    <div role="img" :aria-label="accessibleLabel">
        <div v-for="item in items" :key="item.key" @click="item.clickable && emit('select', item)">
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

use Statamic\Forms\Fields\FormValueType;
use Statamic\Forms\Insights\Insight;
use Statamic\Forms\Summary\FieldResponses;

class MostPopular extends Insight
{
    public function supports(): array
    {
        return [FormValueType::Number, FormValueType::Choice];
    }

    public function props(FieldResponses $responses): array
    {
        return ['answer' => $responses->counts()->sortDesc()->keys()->first()];
    }
}
```

The `supports()` method lists the kinds of answers the insight applies to, just like a chart. The `props()` method receives the field's responses and returns the props for the insight's Vue component. `$responses->counts()` gives you a count for each answer, `$responses->total()` the number of responses, and `$responses->numeric()` the count, sum, min, max and average for numeric answers.

The component is named after the class by default — `most-popular-insight` for the class above — but you can override that with a `$component` property. It receives whatever `props()` returns, along with `metric`. Register it the same way as a chart component:

```js
import MostPopularInsight from './components/insights/MostPopularInsight.vue';

Statamic.booting(() => {
    Statamic.$components.register('most-popular-insight', MostPopularInsight);
});
```

Unlike charts, insights aren't picked in the Control Panel — fieldtypes attach them with their `defaultInsights()` method, which you'll read about next.

### Charting your own fieldtypes

[Custom form fieldtypes](/fieldtypes/build-a-form-fieldtype) opt into the summary using these methods:

| Method | Description |
| --- | --- |
| `valueType()` | The kind of answers the field stores, as a `FormValueType` case. Charts and insights only apply when their `supports()` includes it. Returning `null` (the default) means none apply. |
| `defaultChart()` | The class name of the chart the field uses by default. Returning `null` (the default) keeps the field out of the summary. |
| `chartOptions(FieldResponses $responses)` | The full set of options answers are counted against, in the order they should be charted. Returning `null` (the default) derives the options from the answers themselves. |
| `defaultInsights()` | An array of insight class names to show alongside the chart. |
| `insightConfig(Insight $insight)` | Config passed to each insight, like a `prefix`, `suffix` or `precision`. |

```php
use Illuminate\Support\Collection;
use Statamic\Forms\Charts\ChartOption;
use Statamic\Forms\Charts\VerticalBar;
use Statamic\Forms\Fields\FormValueType;
use Statamic\Forms\Insights\Average;
use Statamic\Forms\Summary\FieldResponses;

public function valueType(): ?FormValueType
{
    return FormValueType::Number;
}

public function defaultChart(): ?string
{
    return VerticalBar::class;
}

public function chartOptions(FieldResponses $responses): ?Collection
{
    return collect(range($this->config('min'), $this->config('max')))
        ->map(fn ($value) => new ChartOption((string) $value));
}

public function defaultInsights(): array
{
    return [Average::class];
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

If `/forms` clashes with something else on your site, or you'd just prefer something different, change the `route` in `config/statamic/forms-pro.php`:

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

- **Logo** — shown in the top-left corner of every Automagic Form. The asset container it's picked from can be set via `asset_container` in `config/statamic/forms-pro.php`; it defaults to your first container.
- **Brand Color** — overrides the color used for buttons and the progress bar. Leave it blank to use the default colors.
- **Background** — the background pattern shown behind every Automagic Form, picked from Steve Schoger's [Heropatterns](https://heropatterns.com/).

### Disabling Automagic Forms

Automagic Forms are enabled by default. If you'd rather disable them entirely, turn them off in `config/statamic/forms-pro.php`:

```php
'automagic_forms' => [
    'enabled' => false,
    // ...
],
```
