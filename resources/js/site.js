import { Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';
import intersect from '@alpinejs/intersect';
import persist from '@alpinejs/persist'
import { registerIconSet, Button, Icon } from '@statamic/ui';
import './collapsible-side-menu.js';
import './anchors.js';
import './cookies.js';
import './color-scheme-preferences.js';
import './font-preferences.js';
import './external-links.js';
import './dl.js';
import './tables.js';
import './language-badges.js';
import './dayjs.js';
import './docsearch.js';
import './torchlight.js';
import './toc-navigation.js';

// Register plugins before starting Alpine
Alpine.plugin(intersect);
Alpine.plugin(persist);

// Start Alpine
Alpine.start();
window.Alpine = Alpine;

import { createApp } from "vue";
const app = createApp({});

// For every export in `@ui`, register it as a Vue component with a `ui-` prefix.
for (const [name, component] of Object.entries(await import('@statamic/ui'))) {
    // If the first letter of name is lower case, skip it. It's not a component.
    if (name[0].toLowerCase() === name[0]) continue;

    const tag = `ui-${name.replace(/([a-z])([A-Z])/g, '$1-$2').toLowerCase()}`;

    app.component(tag, component);
}

registerIconSet('heroicons', import.meta.glob(
    '../svg/heroicons/*.svg',
    { query: '?raw', import: 'default' }
));

app.mount("#main");
