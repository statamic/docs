---
id: 5442a3d6-db7b-41d3-8ab2-2514f8a11eff
blueprint: tag
title: 'Locales:Count'
intro: 'Get the number of localizations.'
---
This tag shares everything from the [locales tag](/tags/locales), except that instead of looping over the results, it will just tell you how many there are.

::tabs

::tab antlers
```antlers
{{ locales:count }}
{{ locales:count self="false" }}
```
::tab blade
```blade
{{-- Using Antlers Blade Components --}}
<s:locales:count />
<s:locales:count self="false" />

{{-- Using Fluent Tags --}}
{{ Statamic::tag('locales:count') }}
{{ Statamic::tag('locales:count')->self(false) }}
```
::

```output
3
2
```
