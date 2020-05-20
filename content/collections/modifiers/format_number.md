---
modifier_types:
  - math
id: 63b56419-6556-4174-8d26-e941460b82a4
---
Format a number with grouped thousands and decimal points. In other words, make it look nice.

- Parameter 1: precision (number of decimal places before rounding)
- Parameter 2: Decimal point (default `.`)
- Parameter 3: Thousands separator (default: `,`)

```.language-yaml
lucky_number: 130134.109
```

```
{{ lucky_number format_number="1|,|," }}
```

```.language-output
130,134,1
```
