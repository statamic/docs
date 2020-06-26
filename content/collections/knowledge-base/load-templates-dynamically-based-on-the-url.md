---
title: 'Load templates dynamically based on the URL'
id: 8eac02d5-1fc1-477c-a571-4aba29f1b60e
intro: If you've ever just wanted to start working on the frontend HTML/CSS without messing around with collections and blueprints yet, here's a fun little trick. These two route rules will give you a homepage and then dynamically map your URLs to match the folder structure of your views directory.
---
## The Snippet
All you need to do is drop these route rules in your `routes/web.php` file. Everything else will work as usual – tags, modifiers, etc, and use the default `layout.antlers.html` layout.

```php
# routes/web.php

use Statamic\View\View;

Route::statamic('/', 'home');

Route::get('{template}', function ($template) {
    return View::make($template)->layout('layout');
})->where('template', '(?!cp).+');
```

_Note: This route rule assumes the control panel login is `/cp` and you're using the default `layout.antlers.html` layout file. You can edit accordingly if you've customized these things. We trust you can figure out which thing to edit where. We believe in you.

## Examples
Here's this route rule in action.

| URL | Template |
|---|---|
| `/` | `resources/views/home.antlers.html` |
| `/design` | `resources/views/design.antlers.html` |
| `/design/stuff` | `resources/views/design/stuff.antlers.html` |
| `/design/your/popsicle` | `resources/views/design/your/popsicle.antlers.html` |

