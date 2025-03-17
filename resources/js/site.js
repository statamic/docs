import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';
import intersect from '@alpinejs/intersect';
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

Alpine.plugin(intersect);
Alpine.start();
window.Alpine = Alpine;

Livewire.start();
