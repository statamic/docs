---
id: 75145be0-966f-490e-af3d-ed122eb6445b
blueprint: modifiers
modifier_types:
  - conditions
  - array
  - string
title: Contains
---
Check if a string or array contains a value. Returns `true` if a match is found, otherwise `false`.

In Antlers method syntax, quote literal strings and leave variable names unquoted. The older colon syntax resolves a matching variable from the context before treating its argument as a literal.

## Strings

String comparisons are case-insensitive by default. Set the second parameter to `true` for a case-sensitive comparison.

```yaml
summary: "It was the best of times, it was the worst of times."
adjective: best
noun: carrot
```

::tabs
::tab antlers
```antlers
{{ summary | contains('BEST') | bool_string }}
{{ summary | contains('BEST', true) | bool_string }}
{{ summary | contains(adjective) | bool_string }}
{{ summary | contains(noun) | bool_string }}
```
::tab blade
```blade
{{ Statamic::modify($summary)->contains('BEST')->boolString() }}
{{ Statamic::modify($summary)->contains(['BEST', true])->boolString() }}
{{ Statamic::modify($summary)->contains($adjective)->boolString() }}
{{ Statamic::modify($summary)->contains($noun)->boolString() }}
```
::

```text
true
false
true
false
```

## Arrays

For a list, this checks its values using loose comparison: the string `'1'` matches the integer `1`. For an associative array, set the second parameter to `true` to check whether the key exists.

```yaml
foods:
  - bacon
  - bread
  - tomato
delicious: bacon
gross: broccoli
numbers: [1, 2]
number: '1'
```

::tabs
::tab antlers
```antlers
{{ foods | contains('bacon') | bool_string }}
{{ foods | contains(delicious) | bool_string }}
{{ foods | contains(gross) | bool_string }}
{{ foods | contains('vegan bacon strips') | bool_string }}
{{ numbers | contains(number) | bool_string }}
```
::tab blade
```blade
{{ Statamic::modify($foods)->contains('bacon')->boolString() }}
{{ Statamic::modify($foods)->contains($delicious)->boolString() }}
{{ Statamic::modify($foods)->contains($gross)->boolString() }}
{{ Statamic::modify($foods)->contains('vegan bacon strips')->boolString() }}
{{ Statamic::modify($numbers)->contains($number)->boolString() }}
```
::

```text
true
true
false
false
true
```
