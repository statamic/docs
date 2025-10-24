---
title: Bard
description: "Rich article writing and block-based layouts made easy."
intro: |
  Bard is more than just a content editor, and more flexible than a block-based editor. **It is designed to provide a delightful and powerful writing experience** with unparalleled flexibility on your front-end.
screenshot: fieldtypes/screenshots/v4/bard-with-sets.png
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

stage: 1
id: f4bf58d3-cbce-4957-b883-d92fd4791e89
---
## Overview

Bard is our recommended fieldtype for creating long form content from the control panel. It's highly configurable, intuitive, user-friendly, and writes impeccable HTML (thanks to [ProseMirror][prosemirror]).

Bard also has the ability to manage "sets" of fields inline with your text. These sets can contain any number of other fields of any [fieldtype](/fieldtypes), and can be collapsed and neatly rearranged in your content.

## Working With Sets {#sets}

You can use any fieldtypes inside your Bard sets. Make sure to compare the experience with the other meta-fields: [Grid](/fieldtypes/grid) and [Replicator](/fieldtypes/replicator). You can even use Grids and Replicators inside your Bard sets. Just remember that because you can doesn't mean you should. Your UI experience can vary greatly.


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

## Custom set icons

You can change the icons available in the set picker by setting an icons directory in a service provider.

For example, you can drop this into your `AppServiceProvider`'s `boot` method:

```php
use Statamic\Fieldtypes\Sets;

public function boot()
{
    Sets::setIconsDirectory(folder: 'light');
}
```

Alternatively, if you want to use a different base directory altogether, you can do this:

```php
Sets::setIconsDirectory(directory: resource_path('custom-icons'));
```
