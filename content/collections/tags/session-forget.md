---
title: 'Session:Forget'
overview: 'The session:forget tag is used to remove data from the user session.'
updated_at: 1573660510
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
id: be024503-9796-4f2f-9c75-548e2ea09cec
published: false
---
## Usage

Data set in the session will be available in all requests until such time that the session is cleared, either over time (sessions eventually expire) or intentionally.

Remove variables from the session by passing a collection of keys into the tag.
```
{{ session:forget keys="likes|referral" }}
```

Or you can wipe the entire session with the flush tag. Keep in mind this will also sign a user out if they're signed in.

```
{{ session:flush }}
```
