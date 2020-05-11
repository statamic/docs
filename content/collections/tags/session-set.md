---
title: 'Session:Set'
overview: 'The session:set tag is used to store and persist data in the user session.'
updated_at: 1573660510
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
id: 90796c5b-6b11-4b02-9e6b-fd70211c825a
---
## Usage

Data set in the session will be available in all future requests until such time that the session is cleared, either over time (sessions eventually expire) or intentionally. Session variables can be retrieved with the base [session](/tags/session) tag.

This can be used for many different things. For example, you could set a set a variable if a user has filled out a special survey form.

```
{{ session:set entered_survey="true" }}
```

Later you could decide to show the user has filled out the form.

```
{{ session }}
    {{ if entered_survey }}
        <p>You already filled out the form.</p>
    {{ /if }}
{{ /session }}
```

## Multiple Variables

You can set multiple variables at once, and reference interpolated data just like all other tags.

```
{{ session:set likes="hats" :referral="get:ref" }}
```

## Tag Pair
This tag is also available as a pair, which allows you to display any data immediately if you so desire.

```
{{ session:set likes="books" }}
    <p>You like {{ likes }}, huh?</p>
{{ /session:set }}
```

## Setting Array Data

You can even set array data with dot notation.

```
{{ session:set likes.books="true" likes.hats="true" }}
```

## Forgetting Data

You can remove data from the session [session:forget](/tags/session-forget), and flush the entire session with [session:flush](/tags/session-flush).
