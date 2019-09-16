---
types:
  - utility
  - string
  - array
id: 23d51738-5043-49e3-8ca3-d5848427216f
---
Inject a variable's data into a partial and render it without any page scopes whatsoever. This is really just syntactical sugar, but it _is_ delicious.

```.language-yaml
data:
  title: Bubble Guppies
  content: Science died a little bit today.
```

```
<!-- /site/themes/<your_theme>/partials/demo.html -->
<h1>{{ title }}</h1>
{{ content | markdown }}

<!-- Template Markup -->
{{ data | partial:demo }}
```

```.language-output
<h1>Bubble Guppies</h1>
<p>Science died a little bit today.</p>
```
