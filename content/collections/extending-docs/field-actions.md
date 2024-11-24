---
id: 41e386b3-9df9-4d28-9338-8005399f953c
blueprint: page
title: 'Field Actions'
template: page
intro: 'Field actions allow you perform JavaScript-based tasks on individual fields within a publish form.'
---
:::tip
If you'd like to perform tasks on entire PHP-based items like Entries, check out [Actions](/extending/actions).
:::

## Overview

Field actions allow you to use JavaScript to modify value for specific fields.

Some examples of what you could do:

- Manipulate the value
- Make the value uppercase
- Translate the value
- Toggle fullscreen mode

## Defining actions

Actions can be added to fieldtypes and Bard/Replicator sets.

You should pass the name of the Vue component and the action object to `Statamic.$fieldActions.add()` method.

```js
Statamic.$fieldActions.add('text-fieldtype', { /* ... */ });
Statamic.$fieldActions.add('bard-fieldtype-set', { /* ... */ });
Statamic.$fieldActions.add('replicator-fieldtype-set', { /* ... */ });
```

The action will be accessible by a dropdown in the field header.

### Within a fieldtype

If you are the fieldtype author, you may choose to define actions internally by adding an `internalFieldActions` computed property to your Vue component.

```js
computed: {
    internalFieldActions() {
        return [
            { ... },  
            { ... },  
        ];
    }    
}
```

## Action Definition

Each action needs at a minimum the `title` and `run` properties.

```js
Statamic.$fieldActions.add('text-fieldtype', {
    title: 'Reverse',
    run: (payload) => {
        //
    }
});
```

The `run` callback will be provided with a [payload object](#callback-payload) containing variables and functions that will be useful to you.

The most basic of which will be `value` and `update` which will let you read the value and update it, respectively.

```js
run: ({ value, update }) => {
    const reversed = value.split('').reverse().join('');
    update(reversed);
}
```

### Loading State

If your action is expected to take a longer amount of time - perhaps you are doing an AJAX request - you may want to provide a loading state.

To add a loading state, return a Promise from your `run` function. A loading graphic will be automatically applied. When resolved, it will be removed.

```js
run: ({ value, update }) => {
    return new Promise(resolve => {
        longTask();
        resolve();
    });
}
```

## Callback Payload

The payload provided to the `run`, `quick`, `visible`, and `icon` functions will contain the following properties:

| Property          | Type     | Description                                                                                                                                |
|-------------------|----------|--------------------------------------------------------------------------------------------------------------------------------------------|
| `handle`          | string   | The handle of the field                                                                                                                    |
| `value`           | mixed    | The value of the field, when used on a field.                                                                                              |
| `values`          | mixed    | The values of the set, when used on a set.                                                                                                 |
| `config`          | Object   | The field configuration                                                                                                                    |
| `meta`            | Object   | The field's meta data                                                                                                                      |
| `update`          | function | Whatever you pass to this method will update the field's value. When used in a set, this expects a field handle as the first argument.     |
| `updateMeta`      | function | Whatever you pass to this method will update the field's meta data. When used in a set, this expects a field handle as the first argument. |
| `fieldPathPrefix` | string   | The path to the field handle, when nested inside another field like a Grid or Replicator.                                                  |
| `vm`              | Object   | The Vue component                                                                                                                          |
| `fieldVm`         | Object   | When inside a Bard or Replicator set, this is the Vue component of the Bard/Replicator.                                                    |
| `isReadOnly`      | bool     | Whether the field is read only.                                                                                                            |
| `confirmation`    | Object   | When using a [confirmation modal](#confirmation-modals), this will contain the result of the submission.                                   |                                   

## Quick Actions

An action can be marked as "quick" and will be made available through an icon in addition to the dropdown. The `icon` can be a name of an icon included with Statamic, or an `<svg>...</svg>` string.

```js
{
    quick: true,
    icon: 'light/crane'
}
```

Either of these may be functions.

```js
{
    quick: (payload) => true,
    icon: (payload) => 'light/crane'
}
```

## Visibility

Since actions are applied to a fieldtype, you may not want to have it usable on every field that uses that fieldtype. You can control whether the action is visible using the `visibile` property.

```js
{
    visible: true
}
```

This may also be a function:

```js
{
    visible: (payload) => true
}
```


## Read Only Fields

By default, Statamic will not display an action if the field is read only. However, you can opt into showing it.

```js
{
    visibleWhenReadOnly: true
}
```

You may also pair this with the `isReadOnly` property within the payload.

```js
{
    visibleWhenReadOnly: true,
    run: ({ update, value, isReadOnly }) => {
        doSomething();
        
        if (!isReadOnly) update(...);
    }
}
```


## Confirmation Modals

When running your action, you may use a modal as confirmation and to ask for additional information.

```js
{
    confirm: true,
    run: () => {
        // do something
    }
}
```

If the user closes the modal without confirming, the `run` won't be executed. 

### Confirmation Modal Options

The `confirm` option will give a generic "Are you sure" prompt if you pass `true`. 

You may pass an options object to the `confirm` property in order to customize it. For example:

```js
{
    confirm: {
        title: 'My Modal',
        text: 'Are you sure you want to do that?'
    }
} 
```

| Option        | Type   | Description                                                                                                      |
|---------------|--------|------------------------------------------------------------------------------------------------------------------|
| `title`       | string | The title to displayed in the header of the modal. Defaults to the title of the action.                          |
| `buttonText`  | string | The text to be displayed in the confirmation button. Default: `Confirm`.                                         |
| `text`        | string | The body text. Defaults to `Are you sure?` if the modal would otherwise be empty (no fields, warning text, etc). |
| `warningText` | string | Red warning text. It will be displayed after confirmationText if defined.                                        |
| `dangerous`   | bool   | Whether the confirmation button should be red.                                                                   | 
| `fields`      | object | An object containing field definitions. See [fields](#confirmation-modal-fields).                                |

### Confirmation Modal Fields

You may provide blueprint field definitions that will be displayed in the modal. A `confirmation` property will be available within the `run` method payload.

```js
{
    confirm: {
        fields: {
            name: {
                type: text,
                display: 'Name',
                instructions: 'Enter your name',
                validate: ['required', 'min:2']
            },
            color: {
                type: color,
                instructions: 'Select the color',
            }
        }
    },
    run: ({ confirmation }) => {
        console.log(confirmation.values);
        // { name: 'Bob Down', color: '#aabbcc' }
    }
}
```

The `confirmation` property is an object containing the following properties:

| Property | Type | Description                                                                       |
|----------|------|-----------------------------------------------------------------------------------|
| `values` | object | The values that are used in the modal's fieldtype Vue components. (Pre-processed) |
| `processed` | object | The PHP-based values. e.g. What would get saved to content when editing an entry. |
| `meta` | object | The meta data for all the fields in the modal.                                    |

## Accessing Other Fields

If you find yourself needing to access other form field values, configs, etc., you can reach into the publish form store from within your run function: 

```js
{
    run: ({ store, storeName }) => {
        const values = store.state.publish[storeName].values;
    }
}
```