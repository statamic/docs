---
modifier_types:
  - markup
  - utility
---
Chunk, A nice and simple way to split up code output and organize your data without going crazy modifying your theme. You may for example find this helpful in a Mega Menu scenario where you want to load your URLS in blocks to appear in some stacked order

Using the Bootstrap grid for our sample: the basic grid code with chunk is:

```
{{ collection:newsroom as="posts" limit="6" }}
<div class="container">
  {{ posts chunk="3" }} 
  <div class="row">
    {{ chunk }}
    <div class="col-sm border bg-light">
      {{ title }}
    </div>
    {{ /chunk }}
  </div>
  {{ /posts }}
</div>
{{ /collection:newsroom }}
```
This outputs:

```
<div class="container">
  <div class="row">
        <div class="col-sm border bg-light">
      How to prepare for an Interview
    </div>
        <div class="col-sm border bg-light">
      Image Test Post
    </div>
        <div class="col-sm border bg-light">
      They call me mellow yellow
    </div>
  </div>
   
  <div class="row">
        <div class="col-sm border bg-light">
      2nd post
    </div>
        <div class="col-sm border bg-light">
      3rd post
    </div>
        <div class="col-sm border bg-light">
      First post
    </div>
    
  </div>
</div>
```

Changing the chunk from `3` to `2` gives us:

```
<div class="container">
   
  <div class="row">
        <div class="col-sm border bg-light">
      How to prepare for an Interview
    </div>
        <div class="col-sm border bg-light">
      Image Test Post
    </div>
  </div>
   
  <div class="row">
        <div class="col-sm border bg-light">
      They call me mellow yellow
    </div>
        <div class="col-sm border bg-light">
      2nd post
    </div>
  </div>
   
  <div class="row">
        <div class="col-sm border bg-light">
            3rd post
    </div>
        <div class="col-sm border bg-light">
      First post
    </div>
    
  </div>
</div>
```
