---
id: ee9e1c05-8b5d-47f9-b476-3d108a9c14af
blueprint: modifiers
modifier_types:
  - markup
  - string
title: Wrap
---
Wraps a string with a given HTML tag. Has the nice benefit of returning null if there is no data, eliminating the need for simple `{{ if }}` wrappers.

```yaml
title: As the World Turns
```

::tabs

::tab antlers
```antlers
{{ title | wrap('h1') }}
```
::tab blade
```blade
{!! Statamic::modify($title)->wrap('h1') !!}
```
::

```html
<h1>As the World Turns</h1>
```

You may also use Emmet-style CSS classes to be added to the tag.

::tabs

::tab antlers
```antlers
{{ title | wrap('h1.fast.furious') }}
```
::tab blade
```blade
{!! Statamic::modify($title)->wrap('h1.fast.furious') !!}
```
::

```html
<h1 class="fast furious">As the World Turns</h1>
```

The `wrap` modifier also accepts passing in arrays. 

```yaml
team_members:
  - Jack
  - Jason
  - Jesse
  - Josh
  - Duncan
  - The Hoff
```

::tabs

::tab antlers
```antlers
{{ team_members | wrap('li') | join(' ') }}
```
::tab blade
```blade
{!! Statamic::modify($team_members)->wrap('li')->join(' ') !!}
```
::

```html
<li>Jack</li>
<li>Jason</li> 
<li>Jesse</li> 
<li>Josh</li> 
<li>Duncan</li> 
<li>The Hoff</li>
```