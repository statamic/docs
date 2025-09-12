---
id: f50e3993-7f40-4a05-9c6f-f0712d24db3a
blueprint: ui_component
title: Icon
template: ui-component
intro: You may use many icons from the streamline icon set.
---
```component
<ui-icon name="bell" />
```

## Custom sets
You may register additional icon sets and then reference them from the component with the `set` prop.

```component
<ui-icon name="academic-cap" set="heroicons" />
```

Register them using the registry API using a glob import. This will include all the icons in the directory in your JS bundle.

```js
import { registerIconSet } from '@statamic/ui';

registerIconSet('heroicons', import.meta.glob(
    './path/to/heroicons/*.svg', 
    { query: '?raw', import: 'default' }
));
```

If you have a situation where you need custom icons that cannot be included in the bundle (for example, how Statamic itself allows you to bring your own icons), you can provide them as strings.

```js
import { registerIconSetFromStrings } from '@statamic/ui';

registerIconSetFromStrings('heroicons', {
    'academic-cap': '<svg>...</svg>',
    'adjustments-horizontal': '<svg>...</svg>',
});
```
