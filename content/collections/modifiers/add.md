---
id: 53debd55-5d53-4254-ad86-49a26cb09594
blueprint: modifiers
modifier_types:
  - math
title: Add
---
Add a value or another variable to your variable. Pass an integer or the name of a second variable as the parameter. Also supports `+` as shorthand.

``` yaml
books: 5
magazines: 10
```

::tabs

::tab antlers

```antlers
{{ books | add:5 }}
{{ books | add:magazines }}
{{ books | +:magazines }}
```
::tab blade
```blade
{{-- Using Modifiers --}}
{{ Statamic::modify($books)->add(5) }}
{{ Statamic::modify($books)->add($magazines) }}
{{ Statamic::modify($books)->add($magazines) }}

{{-- Using PHP --}}
{{ $books + 5 }}
{{ $books + $magazines }}
{{ $books + $magazines }}
```
::

```text
10
15
15
```
