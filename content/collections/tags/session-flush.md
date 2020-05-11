---
title: 'Session:Flush'
overview: 'The session:flush tag is used to clear the entire user session.'
updated_at: 1573660510
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
id: 1f522665-9fc2-4c9f-9594-04a518c51b39
---
## Usage

Data set in the session will be available in all requests until such time that the session is cleared, either over time (sessions eventually expire) or intentionally.

The flush tag will wipe the entire session. Keep in mind this will also sign a user out if they're signed in.

```
{{ session:flush }}
```
