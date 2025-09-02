import { Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';
import intersect from '@alpinejs/intersect';
import persist from '@alpinejs/persist'
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

import { Button } from "../../vendor/statamic/cms/resources/js/components/ui";
import { createApp } from "vue";

const app = createApp({});
app.component("ui-button", Button);
app.mount("#main");
