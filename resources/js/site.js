import "meilisearch-docsearch/css";
import { docsearch } from "meilisearch-docsearch";
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';
import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';
import intersect from '@alpinejs/intersect';
import './anchors.js';
import './cookies.js';
import './external-links.js';
import './language-badges.js';
import './searchHotKeys.js';
// var dayjs = require('dayjs')
dayjs.extend(relativeTime)
window.dayjs = dayjs;

docsearch({
    container: "#docsearch",
    host: "https://search.statamic.dev",
    apiKey: "a8b8f82076221f9595dceca971be29c36cbccd772de5dbdb7f43dfac41557f95",
    indexUid: "default",
    hotKeys: ['ctrl+k', '/']
});

window.bodyData = function() {
    let primaryKeyBind = /(Mac|iPhone|iPod|iPad)/i.test(navigator.platform) ? 'meta' : 'ctrl';
    return {
        showNav: false,
        showSearch: false,
        showEasterEgg: false,
        nearTop: true,
    };
}

window.htmlData = function() {
    return {
        themePickerOpen: false,
        themePreference: localStorage.getItem('theme') || 'system',
        systemTheme: window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light',
        setSystemTheme(theme) {
            this.systemTheme = theme
        },
        get theme() {
            return this.darkMode ? 'dark' : 'light'
        },
        setThemePreference(theme) {
            this.themePreference = theme
            localStorage.setItem('theme', theme)
        },
        get darkMode() {
            return this.themePreference === 'dark' || (this.themePreference === 'system' && this.systemTheme === 'dark')
        },
    }
}

Alpine.plugin(intersect);
Alpine.start();
window.Alpine = Alpine;

console.log('site.js loaded');

// function tocNavigation() {
//     return {
//         activeSection: null,

//         init() {
//             const tocLinks = document.querySelectorAll('ol.toc a');

//             // Find all <h2> elements and observe them
//             document.querySelectorAll('article h2').forEach((h2) => {
//             const id = h2.getAttribute('id');

//             // Use IntersectionObserver to detect when an <h2> enters the viewport
//             const observer = new IntersectionObserver((entries) => {
//                 entries.forEach(entry => {
//                 if (entry.isIntersecting) {
//                     this.activeSection = id;
//                     this.updateActiveLink(id, tocLinks);
//                 }
//                 });
//             }, { threshold: 0.6 }); // Trigger when 60% of the section is in view

//             observer.observe(h2);
//             });
//         },

//         updateActiveLink(sectionId, tocLinks) {
//             // Remove the active class from all links
//             tocLinks.forEach(link => link.classList.remove('active'));

//             // Find the link that corresponds to the sectionId and add the active class
//             const activeLink = document.querySelector(`ol.toc a[href="#${sectionId}"]`);
//             if (activeLink) {
//             activeLink.classList.add('active');
//             }
//         }
//     };
// }

Array.prototype.forEach.call(document.querySelectorAll('code.torchlight'), function (el) {
    if (el.dataset.lang) {
        let badge = document.createElement('div');
            badge.className = 'language-badge';
            badge.innerHTML = el.dataset.lang === 'md' ? 'markdown' : el.dataset.lang;

        el.parentElement.appendChild(badge)
    }
});

Livewire.start();
