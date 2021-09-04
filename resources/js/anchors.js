// Add header anchors
var elements = document.querySelectorAll('article h2, article h3');
Array.prototype.forEach.call(elements, function (el, i) {
    if (el.id) {
        el.innerHTML += '<a href="#' + el.id + '" class="anchor">#</a>';
    }
});
