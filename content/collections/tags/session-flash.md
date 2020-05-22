---
title: 'Session:Flash'
description: 'Store data for a single request.'
intro: Flash data is session data that is only kept for a single request. It is most often used for success/failure messages that automatically disappear after a page refresh.
stage: 5
id: 29957a36-a15a-4fd0-9342-b829b6235fea
---
## Example

```
{{ session:flash message="You did it!" }}
```

The next (and only next) request will then have that variable available.

```
{{ session:message }} // You did it!
```

## Multiple Variables

You can set multiple variables at once and reference interpolated data (references to variables).

```
{{ session:flash success="true" :clicked="order_button" }}
```

## Setting Array Data

Array data can be set with dot notation.

```
{{ session:flash likes.snow_cones="true" likes.italian_ice="false" }}
```
