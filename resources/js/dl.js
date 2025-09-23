document.addEventListener('DOMContentLoaded', function() {
    const dlElements = document.querySelectorAll('.c-entry-content dl');
    
    dlElements.forEach(dl => {
        const ddElements = dl.getElementsByTagName('dd');
        for (let dd of ddElements) {
            if (dd.textContent.toLowerCase().trim() === 'no') {
                dl.classList.add('c-pill--negative');
                break;
            }
        }
    });
});
