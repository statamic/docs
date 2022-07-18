// Add language badges to Torchlight code blocks
var elements = document.querySelectorAll('code.torchlight');
Array.prototype.forEach.call(elements, function (el, i) {
    if (el.dataset.lang) {
        let badge = document.createElement('div');
            badge.className = 'language-badge';
            badge.innerHTML = el.dataset.lang;

        el.parentElement.appendChild(badge)
    }
});
