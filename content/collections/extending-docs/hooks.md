---
title: Hooks
intro: |
  Statamic allows you to hook into specific points and perform asyncronous operations using [Promises](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Promise).
stage: 1
id: fc136da3-ba46-46e1-8443-e345d5b548ac
---
## About

Hooks are programmable interfaces which you can use to modify or extend already existing JavaScript code inside the Control Panel.

Normally they work like this:

1. Statamic code is running
2. Statamic code checks for existing Hooks
3. Your custom hook was found
4. The code inside your custom hook will be run
5. Statamic code continues to run (with modfied data etc.)

## Prerequisites

Before you start using hooks, you need to register the corresponding javascript file.
Please follow the guide on [Adding CSS and JS assets](/extending/control-panel#adding-css-and-js-assets).

## How to use hooks

For example, the `entry.saving` hook allows you to pause saving to perform an action:

```js
Statamic.$hooks.on('entry.saving', (resolve, reject) => {
    if (confirm('Are you sure you want to save this entry?')) {
        // Continue with the save action.
        resolve();
    } else {
        // Cancel the save action. You can provide the error message.
        reject('You chose not to publish.');
    }
});
```

If you intend to work with another promise, make to resolve or reject once it's done:

```js
Statamic.$hooks.on('entry.saving', (resolve, reject) => {
    return axios.get('/something')
        .then(resolve)
        .catch(() => reject('It broke'));
});
```

Some hooks may provide you with a payload containing additional data. For example, the `entry.saving` hook provides you with the collection handle and form values.

```js
Statamic.$hooks.on('entry.saving', (resolve, reject, payload) => {
    console.log(payload.collection); // blog
    console.log(payload.values); // { title: "My Post", content: "Post Content" }
});
```

:::best-practice
When you `reject` a hook, any other code using that hook will not be executed.
Unless your intention is to stop the execution chain, you should always `resolve`, even when your code does nothing.

``` js
Statamic.$hooks.on('example', (resolve, reject) => {
    if (somethingShouldHappen) {
        doSomething();
    }
    resolve();
});
```
:::

## Available hooks

### entry.saving

Triggered when you click save on the publish form.
You can use `reject()` to prevent the request. Payload contains collection name, form values, and a reference to the publish container component.

### entry.saved

Triggered when you click save, but after the request has finished.
Payload contains collection name, and the Axios response.

### entry.publishing

Triggered when revisions are enabled, and you click publish in the publish action stack.
You can use `reject()` to stop the request. Payload contains collection name and revision message.

### entry.published

Triggered when revisions are enabled, but after the request has finished.
Payload contains collection name, revision message, and the Axios response.

### global-set.saving

Triggered when you click save on the publish form.
You can use `reject()` to prevent the request. Payload contains global set name, form values, and a reference to the publish container component.

### global-set.saved

Triggered when you click save, but after the request has finished.
Payload contains global set name, and the Axios response.
