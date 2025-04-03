// Add header anchors
var elements = document.querySelectorAll('article h2:not(.js__no-anchors), article h3:not(.js__no-anchors)');

// If fewer than 3 headings, also include h1s
if (elements.length < 3) {
    elements = document.querySelectorAll('article h1:not(.js__no-anchors), article h2:not(.js__no-anchors), article h3:not(.js__no-anchors)');
}

Array.prototype.forEach.call(elements, function (el, i) {
    // Generate an ID if one doesn't exist
    if (!el.id) {
        // Create ID from heading text: lowercase, remove special chars, replace spaces with hyphens
        el.id = el.textContent.toLowerCase()
            .replace(/[^\w\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+$/, ''); // Remove trailing hyphens which can be cause when an emoji is added to the end e.g. "Writing pure Antlers in Blade 🆕"
    }
    // Add scroll spy timeline track class and incrementing style
    el.classList.add('o-scroll-spy-timeline__track');
    el.setAttribute('style', '--ti-name: --' + (i + 1));
    el.innerHTML += '<a href="#' + el.id + '" class="c-anchor">#</a>';
});