---
title: 'View Models'
intro: View Models give you a chance to manipulate or set data in PHP _right before_ everything is passed into your view, parsed, and then rendered.
template: page
id: fbf59081-ba24-4e82-b011-b687be228c89
blueprint: page
---
## Overview
Have you ever had some complex data or conditions you found challenging to work with in your [Antlers][antlers] templates? Sure you have. Have you ever peeled a banana and had the stem hang onto the peel stubbornly only to have the fruit poke it's face out of a surprise gap like a hoodie? You can probably relate to that too.

While Antlers is powerful and flexible, what if you could just jump into PHP-land, work out some tricky logic, and put the data back in place before it was rendered?

Enough rhetorical questions – in Statamic you can now solve one of those two problems with a View Model. 🍌

## What's a View Model?

By defining a `view_model` in your entry data or anywhere in the [cascade][cascade], Statamic will run the `data()` method of that named class and merge any array data you return before injecting it into your view/template.

While _inside_ the view model, you have access to the full cascade and can set new variables or modify existing ones.

## Example
Let's assume we have a [Replicator][replicator] field with a bunch of content blocks (an associative array) and we'd like to calculate some stats on how much content there is and how long it might take to read it.

**First**, let's define the view model location. Rather than putting it in an entry, we'll put it in the collection so that it's applied to every entry.

```yaml
# content/collections/articles.yaml
title: Articles
inject:
  view_model: App\ViewModels\ArticleStats
```

```yaml
# content/collections/articles/a-long-article.md
title: "A Long Article Plz Read it Mmmkay?"
content:
  -
    type: text
    text: # Piles of content live here
```

**Next,** we'll loop through the content, assemble a giant string of all the content, perform some math, and return the stats.

```php
<?php

namespace App\ViewModels;

use Statamic\View\ViewModel;

class ArticleStats extends ViewModel
{
    public function data(): array
    {
        // Combine content blocks
        $html = collect($this->cascade->get('content'))
                ->implode('text', " ");

        // Remove HTML tags
        $content = strip_tags($html);

        // Calculate stats
        $character_count = strlen($content);
        $word_count      = mb_str_word_count($content);
        $read_time       = ceil($word_count / 200);

        return [
            'character_count' => $character_count,
            'word_count'      => $word_count,
            'read_time'       => $read_time
        ];
    }
}
```

**Finally,** we'll show these stats in our view.

```
<h1>{{ title }}</h1>
<p class="meta">
    {{ word_count }} words / read time approx {{ read_time }}m.
</p>
```

View models help keep your views nice and clean. Use them often and you'll find that they're quickly becoming your new best friend.

:::tip
ViewModels manipulate the _view's_ data at the **last possible moment before render**, not the entry data itself. This approach isn't appropriate for globally altering or manipulating content.

You may consider creating a [computed value](/computed-values) for an entry instead, which would work anywhere, for example in other parts of PHP, or within collection loops in your templates.
:::


[antlers]: /antlers
[cascade]: /cascade
[replicator]: /fieldtypes/replicator
