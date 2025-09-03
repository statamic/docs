---
id: dc9fb687-5d28-40e0-b561-1a5276ab7d4a
blueprint: ui_component
title: Button
template: ui-component
intro: Buttons are used to trigger actions. They come in many sizes and flavors.
---
```component
<ui-button text="Click me" variant="primary"></ui-button>
```

## Variants

Use the `variant` prop to change the appearance of the button.

```component
<ui-button>Default</ui-button>
<ui-button variant="primary">Primary</ui-button>
<ui-button variant="danger">Danger</ui-button>
<ui-button variant="filled">Filled</ui-button>
<ui-button variant="ghost">Ghost</ui-button>
```

## Sizes

<p>Use the <code>size</code> prop to change the size of the button.</p>

```component
<ui-button>Base</ui-button>
<ui-button size="sm">Small</ui-button>
<ui-button size="xs">Extra Small</ui-button>
```


## Icons

Buttons can contain icons through the use of slots or by using the `icon` prop to pass the name of an icon.

```component
<ui-button icon="ui/dots"></ui-button>

<ui-button>
    <ui-icon name="clipboard" text="Copy"></ui-icon>
</ui-button>

<ui-button variant="primary" icon-append="arrow-right">
    Continue
</ui-button>
```


## Round

Round buttons have their place too. Like in Bard set pickers. Just set the `round` prop.

```component
<ui-button icon="plus" round></ui-button>
<ui-button icon="plus" round size="sm"></ui-button>
<ui-button icon="plus" round size="xs"></ui-button>
```


## Loading

Show an animated loading icon during network requests.

```component
<ui-button loading>
    Save
</ui-button>
```


## Full Width

Fill that container with nothing but button.

```component
<ui-button variant="primary" class="w-full">
Save & Continue
</ui-button>
```


## Button Groups

Group buttons together to create a cohesive set of actions.

```component
<ui-button-group>
<ui-button variant="default">Oldest</ui-button>
<ui-button  variant="default">Newest</ui-button>
<ui-button  variant="default">Top</ui-button>
</ui-button-group>
```


## Icon Groups

Group icons together.

```component
    <ui-button-group>
        <ui-button icon="paragraph-align-left"></ui-button>
        <ui-button icon="paragraph-align-center"></ui-button>
    <ui-button icon="paragraph-align-right"></ui-button>
</ui-button-group>
```


## Attached Button

Attach a button to the side of a button to make it a double complete button.

```component
<ui-button-group>
    <ui-button variant="primary">Create Entry</ui-button>
    <ui-button icon="ui/chevron-down" variant="primary"></ui-button>
</ui-button-group>
```

## As a Link

Buttons can be used as links by passing an <code>href</code> prop.

```component
<ui-button href="https://statamic.com" icon-append="arrow-up-right">
    Visit Statamic.com
</ui-button>
```
