---
id: 9e3bb06e-6f3f-460d-9693-c433452d0f96
blueprint: modifiers
modifier_types:
  - array
title: Sort
---
Sort an array by key as parameter 1 and direction (`asc`/`desc`) as parameter 2. If sorting a primitive list no parameters are necessary.

```yaml
primitive:
  - Zebra
  - Alpha
  - Bravo
complex:
  -
    last_name: Zebra
    first_name: Zealous
  -
    last_name: Alpha
    first_name: Altruistic
  -
    last_name: Bravo
    first_name: Blathering
```

```
{{ primitive | sort | list }}

{{ complex | sort($last_name) }}
    Hello, {{ first_name }} {{ last_name }} - {{ key }}
{{ /complex }}

{{ complex | sort($last_name, 'desc') }}
    Hello, {{ first_name }} {{ last_name }} - {{ key }}
{{ /complex }}
```

```html
Alpha, Bravo, Zebra

Hello, Altruistic Alpha
Hello, Blathering Bravo
Hello, Zealous Zebra

Hello, Zealous Zebra
Hello, Blathering Bravo
Hello, Altruistic Alpha
```
