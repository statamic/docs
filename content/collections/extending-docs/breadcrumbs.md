---
title: CP Breadcrumbs
intro: |
  At the top of most pages in the control panel, you will see a title with breadcrumbs sitting above. Statamic provides
  ways to generate these links without you having to worry about manually generating the HTML.
stage: 1
id: a96676fe-0ec4-41f5-9205-2fe47988addb
---
``` php
use Statamic\CP\Breadcrumbs;

$crumbs = Breadcrumbs::make([
    ['text' => 'First', 'url' => '/first'],
    ['text' => 'Second', 'url' => '/second'],
])

return view('myview', ['crumbs' => $crumbs]);
```

``` blade
<breadcrumbs :crumbs='@json($crumbs)'></breadcrumbs>
```

``` vue
<template>
    <breadcrumbs :crumbs="crumbs" />
</template>
<script>
export default {
    data()
        return {
            crumbs: [
                ['text' => 'First', 'url' => '/first'],
                ['text' => 'Second', 'url' => '/second'],
            ]
        ]
    }
}
</script>
```
