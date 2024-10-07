import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';
import intersect from '@alpinejs/intersect'
// import docsearch from '@docsearch/js';
// import '@docsearch/css';
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';

Alpine.plugin(intersect);

console.log('site.js loaded')
// require('./anchors.js')

// var elements = document.querySelectorAll('article h2, article h3, article h4');
// Array.prototype.forEach.call(elements, function (el, i) {
//     if (el.id) {
//         el.innerHTML += '<a href="#' + el.id + '" class="anchor">#</a>';
//     }
// });

// require('./cookies.js')
// require('./external-links.js')
// require('./language-badges.js')

dayjs.extend(relativeTime)

window.dayjs = dayjs;

// docsearch({
//   container: '#docsearch',
//   appId: '90UJMUR5MX',
//   indexName: 'statamic_3',
//   apiKey: '2cea01a83bd805b6c642d3bda0b91437',
//   transformItems(items) {
//     return items.map((item) => {
//         // Transform the absolute URL into a relative URL so it works locally.
//         const a = document.createElement('a');
//         a.href = item.url;

//         // If the result is the h1, remove the hash
//         const hash = a.hash === '#content' ? '' : a.hash;

//         return {...item, url: `${a.pathname}${hash}`}
//     });
//   },
// });

// window.htmlData = function() {
//     return {
//         themePickerOpen: false,
//         themePreference: localStorage.getItem('theme') || 'system',
//         systemTheme: window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light',
//         setSystemTheme(theme) {
//             this.systemTheme = theme
//         },
//         setThemePreference(theme) {
//             this.themePreference = theme
//             localStorage.setItem('theme', theme)
//         },
//         get darkMode() {
//             return this.themePreference === 'dark' || (this.themePreference === 'system' && this.systemTheme === 'dark')
//         },
//     }
// }

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
