function isAppleDevice() {
    return /(Mac|iPhone|iPod|iPad)/i.test(navigator.platform);
}

if (isAppleDevice()) {
    window.addEventListener('keydown', function (e) {
        if (! e.metaKey) {
            return;
        }

        if (e.key.toLocaleLowerCase() !== 'k') {
            return;
        }

        document.getElementsByClassName('docsearch-btn')[0].click();
    });
}
