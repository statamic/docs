---
title: Slugify
id: d84613d5-2b2b-465d-8f02-c71b6d2aadf1
---
You can use the `<slugify>` component to generate a slug based off another property:

``` html
<slugify :from="title" v-model="slug">
    <input slot-scope="{}" :value="slug" @input="slug = $event.target.value" />
</slugify>
```

When the value of the `from` prop changes (ie. the `title` property), it will update the `slug` property.

If you update the slug manually (ie. by typing in the field), the component will realize, and prevent any further automatic slug generation.

If you want underscores instead of dashes, you can pass in `separator="_"`.
