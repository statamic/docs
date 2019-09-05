---
title: Partial
overview: Render a partial template.
parameters:
  -
    name: partial
    type: tag part
    description: "The name of the partial file, relative to the `partials` folder. This is part of the tag, not actually a parameter. For example, you'd use `partial:list` to load the `list` partial."
  -
    name: src
    type: string
    description: |
      The name of the partial. This is just a more verbose syntax, but can allow you to use a variable for the partial name. eg. `{{ partial src="{my_partial}" }}`
  -
    name: variables
    type: multiple params
    description: >
      Any additional parameters specified will
      be sent into the partial as variables.
id: 1f683992-401e-44f6-8506-7967005778a5
---
## Example 1: The header {#example-header}

The most common usage of a partial is to add a header or navigation into a layout file, like this:

```
<html>
<body>
  {{ partial:header }}

  <div class="main">
    {{ template_content }}
  </div>
</body>
</html>
```

The `{{ partial:header }}` tag would output the contents of `site/themes/theme_name/partials/header.html`.  

Splitting your templates up into partials is a nice way to keep things clean and organized. Another great way to keep things tidy is to split up your partials into subdirectories:

```
partials/
|-- nav/
|   |-- top.html
|-- authors/
|   |-- meta.html
|-- session/
|   |-- message.html
```

To render a partial that's inside a subdirectory, we would simply add `{{ partial:$folder/$filename }}` in our template. In other words, to get our top nav partial we would do `{{ partial:nav/top }}`.

## Example 2: The reusable chunk {#example-reuse}

Another common usage for a partial is to pass in data into a reusable chunk of template code.

Here's a partial which outputs a list.

```
<h3>{{ header }}</h3>
<ul>
  {{ items }}
    <li>{{ value }}</li>
  {{ /items }}
</ul>
```

In a page, we might have a list of animals.

``` language-yaml
animals:
  - Stag
  - Rhino
  - Alligator
```

Then in our template, we want to output those animals using the partial.

```
<div>
  {{ partial:list header="Favorite Animals" :items="animals" }}
</div>
```

The resulting output would look like this:

```
<h3>Favorite Animals</h3>
<ul>
  <li>Stag</li>
  <li>Rhino</li>
  <li>Alligator</li>
</ul>
```

The `:items` parameter was prefixed by a colon, which means it will be [retrieved from the context](/antlers#vars-in-params).
