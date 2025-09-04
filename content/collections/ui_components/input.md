---
id: 17864a99-9a46-4ec3-b3c4-0fb11ad39ed1
blueprint: ui_component
title: Input
template: ui-component
intro: The classic form text input.
---
```component
<ui-input name="email" type="email" placeholder="Email goes here" />
```

## Labels and descriptions

You can assemble your own input field with a label, description, input, and anything else you want.

```component
<ui-field>
    <ui-label required>Email</ui-label>
    <ui-description>We need it so we can sell your info to spammers.</ui-description>
    <ui-input name="email" type="email" />
</ui-field
```


## Types

Use the browser's various input types for different situations: `text`, `email`, `password`, etc.

```component
<ui-input type="email" label="Email" placeholder="Email" />
<ui-input type="password" label="Password" placeholder="Password" />
<ui-input type="date" label="Date" placeholder="Date" />
```


## Icons

Add an icon to your input by passing the name of the with `icon` prop. You can use `icon-append` and `icon-prepend` to add an icon to the input's end and start, respectively.

```component
<div class="flex flex-col gap-3 w-full max-w-md">
    <ui-input label="Email" icon="mail" placeholder="jim@bob.com" />
    <ui-input label="Email" icon-append="mail" placeholder="jim@bob.com" />
    <ui-input label="Email" icon-prepend="mail" placeholder="jim@bob.com" />
</div>
```


## Sizes

Use the `size` prop to control the input's height and type scale. The scales match the button sizes to make sure everything lines up nicely.

```component
<ui-input type="text" placeholder="Default" icon-append="mail" />
<ui-input size="sm" type="text" placeholder="Small" icon-append="mail" />
<ui-input size="xs" type="text" placeholder="Extra Small" icon-append="mail" />
```


## Slots

You can use the `prepend` and `append` slots to have more control over the output, add a button, and so on.

```component
<ui-input label="Email" placeholder="jim@bob.com">
    <template #append>
        <ui-button icon="arrow-right" variant="ghost" size="sm"/>
    </template>
</ui-input>
```


## Clearable
Add a clear button to your input by passing the `clearable` prop.

```component
<ui-input label="Email" clearable value="jim@bob.com" />
```


## Copyable
Add a copy button to your input by passing the `copyable` prop.

```component
<ui-input label="Secret" copyable readonly v-model="values.secret" />
```


## Viewable
Add a button to toggle showing a password's text by passing the viewable prop.

```component
<ui-input label="Password" type="password" viewable v-model="values.password" />
```


## Text prepend and append

Prepend or append content to your inputs by using the `prepend` and `append` props, respectively.

```component
<ui-input name="url" prepend="https://" append=".com" value="statamic" />
```



## Character Limit

Add a character limit indicator to the input with `limit`. This does not set a hard stop, but is rather just for user feedback only.

```component
<ui-input
    name="toot"
    :limit="240"
    model-value="When you get close to the limit, you'll know."
/>
```
