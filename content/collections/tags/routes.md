---
title: Routes
is_parent_tag: true
overview: Loop through your Template Routes and access inline data.
variables:
  -
    name: url
    type: string
    description: The route's URL
  -
    name: permalink
    type: string
    description: The route's fully qualified permalink
  -
    name: template
    type: string
    description: The specified template
  -
    name: \*
    type: mixed
    description: Any other inline variables
id: ad1b968e-9069-4977-a8ba-b12fe7885ebe
---
This tag can save you from having to hardcode links to your [Template Routes](/routing#template-routes) and gives you access to any inline data you added in your route rules too. It's a simple thing. Don't overthink it.

## Example {#example}

```.language-yaml
/contact: contact
/press:
  template: press
  title: Press & Media Resources
  show_sidebar: false

```

```
{{ routes }}
  <a href="{{ url }}">{{ title or template | deslugify | title }}</a>
{{ /routes }}
```

```.language-output
  <a href="/contact">Contact</a>
  <a href="/press">Press & Media Resources</a>
```
