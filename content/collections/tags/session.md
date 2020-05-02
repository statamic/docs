---
title: Session
description: 'Get, set, and forget data in your user''s session.'
overview: 'Sessions provide a stateless way to store information about the user across requests. The session tag will let you get, set, and forget session data.'
is_parent_tag: true
updated_at: 1573660509
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
id: c15836c2-808d-4260-9d01-e5a569da5b5a
---
## Retrieving Session Data

You can use `{{ session }}` as a tag pair to access all the data inside your user's session.

```
{{ session }}
    {{ message }}
{{ /session }}
```

```.output
Welcome to the session.
```

You can also retrieve single variables with a single tag syntax.

```
{{ session:message }}
```

## Aliasing

If you need extra markup around your session data, you can _alias_ a new child array variable.

```
{{ session as="sesh" }}
  {{ sesh }}
    {{ message }}
  {{ /sesh }}
{{ /session }}
```

## Setting and Forgetting

You can set data with [session:set](/tags/session-set), flash data with [session:flash](/tags/session-flash), forget it with [session:forget](/tags/session-forget), and flush the entire session with [session:flush](/tags/session-flush).

## Debugging

If you want to peek into the session and check the data, do so with with [session:dump](/tags/session-dump) or the [debug bar](/debugging#debug-bar).
