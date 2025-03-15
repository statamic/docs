// Add header anchors
var elements = document.querySelectorAll('article h2, article h3, article h4');
Array.prototype.forEach.call(elements, function (el, i) {
    // Generate an ID if one doesn't exist
    if (!el.id) {
        // Create ID from heading text: lowercase, remove special chars, replace spaces with hyphens
        el.id = el.textContent.toLowerCase()
            .replace(/[^\w\s-]/g, '')
            .replace(/\s+/g, '-');
    }
    el.innerHTML += '<a href="#' + el.id + '" class="anchor">#</a>';
});