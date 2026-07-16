function isMac() {
    if (navigator.userAgentData?.platform) {
        return navigator.userAgentData.platform === 'macOS';
    }

    return /Mac|iPhone|iPod|iPad/i.test(navigator.platform);
}

document.addEventListener('DOMContentLoaded', () => {
    if (isMac()) {
        return;
    }

    document.querySelectorAll('kbd').forEach((kbd) => {
        if (kbd.textContent.trim() === '⌘') {
            kbd.textContent = 'Ctrl';
        }
    });
});
