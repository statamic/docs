// Add header anchors
var elements = document.querySelectorAll('article :is(h2, h3, h4, h5, h6):not(.js__no-anchors)');

// If fewer than 3 headings, also include h1s
if (elements.length < 3) {
    elements = document.querySelectorAll('article :is(h1, h2, h3, h4, h5, h6):not(.js__no-anchors)');
}

Array.prototype.forEach.call(elements, function (el, i) {
    // Add scroll spy timeline track class and incrementing style
    el.classList.add('o-scroll-spy-timeline__track');
    el.setAttribute('style', '--ti-name: --' + (i + 1));
});