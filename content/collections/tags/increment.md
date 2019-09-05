---
title: Increment
parse_content: false
overview: "This tag will create an incrementing index for you. Each time the tag is parsed it will increment its value by one."
description: "This tag will create an incrementing index for you."
parameters:
  -
    name: from
    type: integer *default 0*
    description: |
      Pass a number you'd like to start incrementing from.
  -
    name: by
    type: integer *default 1*
    description: |
      Pass a number you'd like to increment by.
id: b33aa176-06e6-411d-a4b7-0a514f697d78
---
## Usage

Let's assume we have a `loop_of_6` variable (or tag pair) that has 6 items in it and we'd like to track an independent counter. Maybe we've encountered a scoping challenge with the native indexes, or perhaps that's being overridden in some other way (aka The Curse of Nested Loops&trade;).

Enter `{{ increment }}` to save the day!

With `{{ increment }}` you can have multiple counters going at different times and also customize the number you want to start from and the amount to increment by.

```
{{ loop_of_6 }}
    {{ increment }}
{{ /loop_of_6 }}

<!-- Break -->

{{ loop_of_6 }}
    {{ increment:two from="10" by="2" }}
{{ /loop_of_6 }}
```

```.language-output
0 1 2 3 4 5

<!-- Break -->

10 12 14 16 18 20
```

## Multiple Instances

As seen in the example above, you can have multiple counter instances by passing the tag a unique name. Feel free to use as many as you'd like, giving each its very own name.
