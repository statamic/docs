---
title: Bard
description: "Rich article writing and block-based layouts made easy."
intro: |
  Bard is more than just a content editor, and more flexible than a block-based editor. **It is designed to provide a delightful and powerful writing experience** with unparalleled flexibility on your front-end.
screenshot: fieldtypes/screenshots/v6/bard-with-sets.webp
screenshot_dark: fieldtypes/screenshots/v6/bard-with-sets-dark.webp
options:
  -
    name: allow_source
    type: boolean
    description: |
      Controls whether the "show source code" button is available to your editors. Default: `true`.
  -
    name: sets
    type: array
    description: An array containing sets of fields. If you don't provide any sets, Bard will act like a basic text/WYSIWYG editor and you won't see the "Add Set" button.
  -
    name: buttons
    type: array
    description: |
      An array of buttons you want available in the toolbar.
      You can choose from `h1`, `h2`, `h3`, `h4`, `h5`, `h6`, `bold`, `italic`, `small`, `underline`, `strikethrough`, `unorderedlist`, `orderedlist`, `removeformat`, `quote`, `anchor`, `image`, `table`, `code` (inline), `codeblock`, and `horizontalrule`.

      These are the defaults:
      ![Bard Buttons](/img/fieldtypes/screenshots/bard-buttons.png) {.mt-4}

      You can override the default buttons using the `Bard::setDefaultButtons()` method:
      ```php
      \Statamic\Fieldtypes\Bard::setDefaultButtons(['h2', 'h3', 'bold', 'italic']);
      ```

      When you have the `image` button toggled, make sure to define an Asset Container in the Bard field's settings, otherwise the button won't show.
  -
    name: target_blank
    type: boolean
    description: |
      Automatically add `target="_blank"` on links by default. You'll be able to override this per-link. Default: `false`.
  -
    name: link_noopener
    type: boolean
    description: |
      Set `rel="noopener"` on all created links. Default: `false`.
  -
    name: link_noreferrer
    type: boolean
    description: |
      Set `rel="noreferrer"` on all created links. Default: `false`.
  -
    name: fullscreen
    type: boolean
    description: |
      Enable the option to toggle into fullscreen mode. Default: `true`.
  -
    name: collapse
    type: boolean
    description: >
      Expand (`true`) or collapse (`false`) all sets by default. Default: `false`.
  -
    name: container
    type: string
    description: >
      An asset container ID. When specified, the fieldtype will allow the user to add a link to an asset from the specified container.
  -
    name: inline
    type: boolean
    description: |
      Switch the field to inline mode. Block elements such as sets, headings and images are not supported in inline mode and should not be enabled.
  -
    name: inline_hard_breaks
    type: boolean
    description: |
      Enable support for hard breaks in inline mode. Only works when `inline` is set to `true`. Default: `false`.
  -
    name: toolbar_mode
    type: string
    description: >
      Choose which style of toolbar you prefer, `fixed` or `floating`. Default: `fixed`.
  -
    name: reading_time
    type: boolean
    description: >
      Show estimated reading time at the bottom of the field. Default: `false`.
  -
    name: word_count
    type: boolean
    description: >
      Show the word count at the bottom of the field. Default: `false`.
  -
    name: save_html
    type: boolean
    description: >
      Save as HTML instead of structured data. This simplifies templates so you don't need to loop through the structured nodes. Only works while no sets are defined. Default: `false`.
  -
    name: always_show_set_button
    type: boolean
    description: >
      Always show the "Add Set" button. Default: `false`.
  -
    name: remove_empty_nodes
    type: string
    description: >
      Choose how to deal with empty nodes. Options: `false`, `true`, `trim`. Default: `false`.

id: f4bf58d3-cbce-4957-b883-d92fd4791e89
---
## Overview

Bard is our recommended fieldtype for creating long form content from the control panel. It's highly configurable, intuitive, user-friendly, and writes impeccable HTML (thanks to [ProseMirror][prosemirror]).

Bard also has the ability to manage "sets" of fields inline with your text. These sets can contain any number of other fields of any [fieldtype](/fieldtypes), and can be collapsed and neatly rearranged in your content.

## Working With Sets {#sets}

You can use any fieldtypes inside your Bard sets. Make sure to compare the experience with the other meta-fields: [Grid](/fieldtypes/grid) and [Replicator](/fieldtypes/replicator). You can even use Grids and Replicators inside your Bard sets. Just remember that because you can doesn't mean you should. Your UI experience can vary greatly.

### Set Previews

New to Statamic v6, you can add an image preview of your set, _as well as_ an icon. Previews make it easy to identify sets by showing a screenshot of what the rendered set might look like on the front-end. Clients can now say “ah, that one” without pretending to know the names you carefully gave them.

#### Configuring Set Previews

To add a set preview, click the little "pencil" icon next to the set name.

<figure>
    <img src="/img/fieldtypes/screenshots/v6/bard-set-edit-preview.webp" alt="Bard Set Edit Preview" class="u-hide-in-dark-mode">
    <img src="/img/fieldtypes/screenshots/v6/bard-set-edit-preview-dark.webp" alt="Bard Set Edit Preview" class="u-hide-in-light-mode">
    <figcaption>Let's give the set a preview.</figcaption>
</figure>

Once you're in the set editor, you can add a preview image and icon. Here we're showing a lovely screenshot of what the newsletter signup form might look like on the front-end. We can even add some instructions to explain how the set is used.

<figure>
    <img src="/img/fieldtypes/screenshots/v6/bard-set-previews.webp" alt="Bard Set Previews" class="u-hide-in-dark-mode">
    <img src="/img/fieldtypes/screenshots/v6/bard-set-previews-dark.webp" alt="Bard Set Previews" class="u-hide-in-light-mode">
    <figcaption>Behold a <em>Preview Image</em>, for the love of all clients.</figcaption>
</figure>

#### Set Previews in Action

Once you've set a preview image, users adding a bard set can hover over the set to preview what it might look like on the frontend.

You can view previews in two different UI modes: in a list of set names, or in a grid of sets with their preview images.

<figure>
    <img src="/img/fieldtypes/screenshots/v6/bard-hover-preview-list.webp" alt="Bard Set Previews in the CP" class="u-hide-in-dark-mode">
    <img src="/img/fieldtypes/screenshots/v6/bard-hover-preview-list-dark.webp" alt="Bard Set Previews in the CP" class="u-hide-in-light-mode">
    <figcaption>A preview in a list of sets.</figcaption>
</figure>

<figure>
    <img src="/img/fieldtypes/screenshots/v6/bard-hover-preview-grid.webp" alt="Bard Set Previews in the CP" class="u-hide-in-dark-mode">
    <img src="/img/fieldtypes/screenshots/v6/bard-hover-preview-grid-dark.webp" alt="Bard Set Previews in the CP" class="u-hide-in-light-mode">
    <figcaption>A preview in a grid of sets. Previews fall back to the set icon if no preview image is set.</figcaption>
</figure>

### Custom Set Icons

You can change the icons available in the set picker by configuring an icon set in a service provider.

For example, you can drop this into your `AppServiceProvider`'s `boot` method:

```php
use Statamic\Fieldtypes\Sets;

public function boot()
{
    Sets::useIcons('heroicons', resource_path('svg/heroicons'));
}
```

## Data Structure

Bard stores your data as a [ProseMirror document](https://prosemirror.net/docs/ref/#model.Document_Structure). You should never need to interact with this data directly, thanks to [augmentation](/augmentation).

## Templating

### Without Sets

If you are using Bard just as a rich text editor and have no need for sets you would use a single tag to render the content.

::tabs

```antlers
{{ bard_field }}
```

::tab

```blade
{!! $bard_field !!}
```

::

### With Sets

When working with sets, you should use the tag pair syntax and `if/else` conditions on the `type` variable to style each set accordingly. **Note**: any content that is entered _not_ in a set (i.e. your normal rich-text content) needs to be rendered using the "text" type. See the first condition using "text."

::tabs

```antlers
{{ bard_field }}

  {{ if type == "text" }}
    <div class="text">
      {{ text }}
    </div>

  {{ elseif type == "poll" }}
    <figure class="poll">
      <figcaption>{{ question }}</figcaption>
      <ul>
        {{ options }}
          <li>{{ text }}</li>
        {{ /options }}
      </ul>
    </figure>

  {{ elseif type == "hero_image" }}
    <div class="heroimage">
      <img src="{{ hero_image }}" alt="{{ caption }}" />
    </div>
  {{ /if }}

{{ /bard_field }}
```

::tab

```blade
@foreach ($bard_field_with_sets as $set)
	@if ($set->type === 'text')
	<div class="text">
		{!! $set->text !!}
	</div>
	@elseif ($set->type === 'poll')
	<figure class="poll">
		<figcaption>{{ $set->question }}</figcaption>
		<ul>
			@foreach ($set->options as $option)
				<li>{{ $option->text }}</li>
			@endforeach
		</ul>
	</figure>
	@elseif ($set->type === 'hero_image' && $hero_image = $set->hero_image)
		<div class="heroimage">
			<img src="{{ $hero_image }}" alt="{{ $hero_image->caption }}" />
		</div>
	@endif
@endforeach
```

::

An alternative approach (for those who like DRY or small templates) is to create multiple "set" partials and pass the data to them dynamically, moving the markup into corresponding partials bearing the set's name.

::tabs

::tab antlers

```antlers
{{ bard_field }}
  {{ partial src="sets/{type}" }}
{{ /bard_field }}
```

``` files theme:serendipity-light
resources/views/partials/sets/
  gallery.antlers.html
  hero_image.antlers.html
  poll.antlers.html
  text.antlers.html
  video.antlers.html
```

::tab blade

:::tip
By using `[...$set]`, you can access the set variables within the set's Blade file without having to reference `$set` for each variable.

For example, `{!! $set->text !!}` becomes `{!! $text !!}`.
:::

```blade
@foreach ($bard_field_with_sets as $set)
	@include('fieldtypes.bard.sets.'.$set->type, [...$set])
@endforeach
```

``` files theme:serendipity-light
resources/views/partials/sets/
  gallery.blade.php
  hero_image.blade.php
  poll.blade.php
  text.blade.php
  video.blade.php
```

::

## Extending Bard

Bard uses [TipTap](https://tiptap.dev/) (which in turn is built on top of [ProseMirror][prosemirror]) as the foundation for our quintessential block-based editor.

[Learn how to extend Bard](/extending/bard)



[prosemirror]: https://prosemirror.net/