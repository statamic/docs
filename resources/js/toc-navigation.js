// [1] Find all <h2> elements inside .js__scroll-spy-toc__timeline and observe them
// [2] Find all the corresponding a elements with the same ids in .js__scroll-spy-toc
// [3] Add an event listener to each a element to check if it is currently in view
// [4] If it is, add the active class to the a element
// [5] If it is not, remove the active class from the a element
// [6] Update the activeSection state variable to the id of the section that is currently in view
// [7] Update the activeLink state variable to the link that is currently in view

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
            threshold: 0.1,  // Reduced threshold
            rootMargin: '-10% 0px -50% 0px'  // Added rootMargin
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
