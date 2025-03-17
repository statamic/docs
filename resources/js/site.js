import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';
import intersect from '@alpinejs/intersect';
import persist from '@alpinejs/persist'
import './anchors.js';
import './cookies.js';
import './color-scheme-preferences.js';
import './external-links.js';
import './language-badges.js';
import './searchHotKeys.js';
import './dayjs.js';
import './docsearch.js';
import './torchlight.js';
import './toc-navigation.js';

// Register plugins before starting Alpine
Alpine.plugin(intersect);
Alpine.plugin(persist);

// Start Alpine and Livewire
Alpine.start();
window.Alpine = Alpine;

Livewire.start();
