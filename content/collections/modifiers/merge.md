---
id: d15bda69-36ee-4871-82b2-e66447868643
blueprint: modifiers
title: Merge
---

Merge an array variable with another array variable.

Array 1:
```html
//Yaml
fruit:
  - apples
  - bananas
  - bacon
  
//Template
{{ fruit }}

//Output
apples bannanas bacon
```

Array 2:
```html
//Yaml
meat:
  - pork
  - beef
  - chicken
  
//Template
{{ meat }}

//Output
pork beef chicken
```

Usage:
```html
//template
{{ fruit merge="meat" }}
  {{ value }}
{{ /fruit }}

//output
apples bananas bacon pork beef chicken 
```


