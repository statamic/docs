---
title: Partial
description: Renders a partial view
intro: Partials are reusable [views](/views) that may find themselves in any number of other layouts, templates, and other partials.
parameters:
  -
    name: src
    type: string
    description: |
      You can pass the name of the partial with a parameter instead of tag argument. Example: `src="cards/author_bio"` or `:src="var_name"`.
stage: 4
id: 1f683992-401e-44f6-8506-7967005778a5
---
## Overview

You can use any view as a partial by using this here partial tag.

```
// This will import /resources/views/blog/_card.antlers.html
{{ partial:blog/card }}
```

We recommend prefixing any views intended to be only used as partials with an underscore, `_like-this.antlers.html`. You don’t need to include the underscore in your partial tag.

## Passing Data

You can pass additional data into a partial via on-the-fly parameters. The parameter name will become a variable inside the partial. The only reserved parameter is `src`, so you can name your variables just about anything.

```
{{ partial:list header="favorite ice cream flavors" :items="flavors" }}

// Inside `list.antlers.html`
<h2>These are my {{ header }}</h2>
{{ items | ul }}
```

``` output
<h2>These are my favorite ice cream flavors</h2>
<ul>
  <li>Chocolate Chip Cookie Dough</li>
  <li>Mint Chocolate Chip</li>
  <li>Neon Mind Melter</li>
</ul>
```

Note that the `:items` parameter is prefixed by a colon, meaning it will pass the _value_ of a `flavors` variable, if it exists.

## Related Reading

If you haven't read up on [views](/views) yet, you should. It's fundamental knowledge, just like knowing that seals are just dog mermaids.
