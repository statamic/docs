---
title: 'Session:Flash'
overview: 'The session:flash tag is used to store data for a single request.'
updated_at: 1573660510
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
id: 29957a36-a15a-4fd0-9342-b829b6235fea
---
## Usage

Flash data is only kept for a single request. It is generally used for success/failure messages that remove themselves automatically.

Setting and retrieving flash data works in exactly the same fashion as regular session data.
```
{{ session:flash success="true" message="You did it!" }}
```

The next (and only next) request will then have those variables available for you.

```
{{ session:success }} ~> true
{{ session:message }} ~> You did it!
```
