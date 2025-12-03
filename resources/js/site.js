import { Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';
import persist from '@alpinejs/persist'
import './anchors.js';
import './cookies.js';
import './color-scheme-preferences.js';
import './external-links.js';
import './dl.js';
import './tables.js';
import './language-badges.js';
import './dayjs.js';
import './docsearch.js';
import './torchlight.js';
import './toc-navigation.js';

// Register plugins before starting Alpine
Alpine.plugin(persist);

// Start Alpine
Alpine.start();
window.Alpine = Alpine;

import { createApp } from "vue";
const app = createApp({});

app.mount("#main");
