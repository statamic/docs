function tocNavigation() {
    const state = {
        activeSection: null,
        activeLink: null
    };

    function init() {
        // [1] Find all heading elements (h2-h3)
        const headingElements = document.querySelectorAll('.js__scroll-spy-toc__timeline h2, .js__scroll-spy-toc__timeline h3');
        
        // [2] Find all TOC links
        const tocLinks = document.querySelectorAll('.js__scroll-spy-toc a');

        // Create intersection observer
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                const id = entry.target.getAttribute('id');
                
                if (entry.isIntersecting) {
                    // [6] Update active section
                    state.activeSection = id;
                    
                    // [4] & [5] Update active classes
                    tocLinks.forEach(link => {
                        link.classList.remove('js--scroll-spy-toc-active');
                        if (link.getAttribute('href') === `#${id}`) {
                            link.classList.add('js--scroll-spy-toc-active');
                            // [7] Update active link
                            state.activeLink = link;
                        }
                    });
                }
            });
        }, { 
            threshold: 0.75, // Sets how much of the element needs to be visible before the observer triggers. e.g. 0.1 means 10% of the element must be visible
            rootMargin: '-10% 0px -50% 0px' // Added rootMargin
        });

        // [3] Observe each heading element
        headingElements.forEach(heading => observer.observe(heading));
    }

    return { init };
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    tocNavigation().init();
});
