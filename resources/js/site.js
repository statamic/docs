import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';
import intersect from '@alpinejs/intersect';
import './anchors.js';
import './cookies.js';
import './external-links.js';
import './language-badges.js';
import './searchHotKeys.js';
import './dayjs.js';
import './docsearch.js';

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
