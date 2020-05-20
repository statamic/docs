---
modifier_types:
  - string
  - utility
id: 6a0abbe0-860a-4e30-b1e7-ecac343149ce
---
Provide an estimate of the read time in minutes based on a given number of words per minute. Defaults to 200/wpm.

```.language-yaml
---
title: A long post
---
Pretend there are lots of words here...
```

```
<h1>{{ title }}</h1>
<p>{{ content | read_time:180 }} min</p>
```

```.language-output
<h1>A long post</h1>
<p>10 min</p>
```
