---
id: 36342e2a-aa6d-4e4b-898e-77e78c958470
blueprint: tag
title: 'Session:Has'
description: 'Check if data exists in the user session.'
intro: 'This tag checks the session to see if any given keys exist in a user session.'
related_entries:
  - c15836c2-808d-4260-9d01-e5a569da5b5a
  - 90796c5b-6b11-4b02-9e6b-fd70211c825a
---
## Example

This is a very simple tag designed to be used in a condition statement. You may check to see if a key has been set (most likely by the [session:set](/tags/session-set) tag) in the session. It returns either `true` or `false`.

```
{{ if {session:has key="entered_survey"} }}
    <p>You already filled out the survey. Thanks for your feedback!</p>
{{ /if }}
```
