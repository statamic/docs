---
id: d15bda69-36ee-4871-82b2-e66447868643
blueprint: modifiers
title: Merge
---

Merge an array variable with another array variable.

```yaml
good_ideas:
  - Exercise regularly
  - Brush your teeth
  - Use Oxford Commas
bad_ideas:
  - Bath in beans
  - Wear sandpaper underwear
  - Eat turtle shells
```

In this template example we'll merge the two arrays and then pull out a single random item from the combined list. For fun!
```
<h2>Picking a random idea!</h2>
{{ good_ideas merge="bad_ideas" sort="random" limit="1" }}
<p>{{ value }}</p>
{{ /good_ideas }}
```

```
<p>Use Oxford Commas</p>
```
