Array.prototype.forEach.call(document.querySelectorAll('code.torchlight'), function (el) {
    if (el.dataset.lang) {
        let badge = document.createElement('div');
            badge.className = 'language-badge';
            badge.innerHTML = el.dataset.lang === 'md' ? 'markdown' : el.dataset.lang;

        el.parentElement.appendChild(badge)
    }
});