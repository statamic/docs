---
id: d1741062-a702-46ae-b304-4aeaf37a2401
blueprint: ui_component
title: Card
template: ui-component
intro: The ubiquitous container of all elements! The div of any component system. Cards can contain anything you want – content, widgets, settings, forms, you name it.
---
```component
<ui-card class="space-y-6 w-92 mx-auto">
    <header>
        <ui-heading size="lg">Create a new account</ui-heading>
        <ui-subheading>Welcome to the thing! You're gonna love it here.</ui-subheading>
    </header>
    <ui-input label="Name" placeholder="Your name"></ui-input>
    <ui-input label="Email" type="email" placeholder="Your email"></ui-input>
    <div class="space-y-2 pt-6">
        <ui-button variant="primary" class="w-full" text="Continue" type="submit"></ui-button>
        <ui-button variant="ghost" class="w-full">Already have an account? Go sign in</ui-button>
    </div>
</ui-card>
```


## Inset

Remove all the inner padding to set the content flush to the sides with the <code>inset</code> prop.

```component
<ui-card inset class="w-64">
<img class="rounded-t-xl" src="https://images.unsplash.com/photo-1549524362-47d913ec9a0e?q=80&w=640&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" />
<div class="p-4 text-sm">
    <strong>This is me</strong>. I am an amazing motocross stunt driver and am available for weddings, parties, and bar mitzvahs.
</div>
</ui-card>
```

## Card Panels

Card panels are one of the most common patterns throughout our UI system. They help create visual context to your interfaces and help break up long forms.

```component
<ui-card-panel heading="Card Panel">
    This is a card panel.
</ui-card-panel>
```


## Composing card panels

The UI Kitt's components are designed to be composible. You can create your own unqiue card panels by combining smaller components however you wish, even mixing in your own HTML, CSS, and/or Tailwind.

```component
<ui-panel>
    <ui-panel-header class="flex items-center justify-between">
        <ui-heading text="Composed Card Panel"></ui-heading>
        <ui-button icon="download" text="Action" size="sm"></ui-button>
    </ui-panel-header>
    <ui-card>
        This is a composed card panel.
    </ui-card>
</ui-panel>
```
