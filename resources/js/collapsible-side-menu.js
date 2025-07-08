// Initialize collapse-nav to 'no' if it hasn't been set yet
if (!localStorage.getItem('collapse-nav')) {
    localStorage.setItem('collapse-nav', 'no');
    console.log('collapse-nav not set yet');
}

// Function to collapse navigation (uncheck inputs)
function collapseNavigation() {
    document.querySelectorAll('.o-toggle-subnav').forEach(element => {
        if (!element.matches(':has(+ ul .o-current-menu-item)')) {
            element.querySelector('input').checked = false;
        }
    });
    Array.from(document.querySelectorAll('.js__expand-collapse-nav') || []).forEach(element => {
        element.classList.remove('js__expand-collapse-nav--collapsed');
    });
}

// Function to expand navigation (check inputs)
function expandNavigation() {
    document.querySelectorAll('.o-toggle-subnav').forEach(element => {
        if (!element.matches(':has(+ ul .o-current-menu-item)')) {
            element.querySelector('input').checked = true;
        }
    });
    Array.from(document.querySelectorAll('.js__expand-collapse-nav') || []).forEach(element => {
        element.classList.add('js__expand-collapse-nav--collapsed');
    });
}

// Function to handle navigation collapse/expand
function toggleNavigation() {
    if (localStorage.getItem('collapse-nav') === 'yes') {
        expandNavigation();
        localStorage.setItem('collapse-nav', 'no');
    } else {
        collapseNavigation();
        localStorage.setItem('collapse-nav', 'yes');
    }
}

// Add click handlers
Array.from(document.querySelectorAll('.js__expand-collapse-nav') || []).forEach(element => {
    element.onclick = toggleNavigation;
});

// Apply saved state on page load
window.addEventListener('DOMContentLoaded', (event) => {
    // Add class to prevent animations during initial state application
    Array.from(document.querySelectorAll('.o-toggle-subnav-container') || []).forEach(element => {
        element.classList.add('u-disable-animation');
    });

    if (localStorage.getItem('collapse-nav') === 'yes') {
        collapseNavigation();
    } else {
        expandNavigation();
    }
    
    // Remove the class after a short delay to allow state to be applied
    setTimeout(() => {
        Array.from(document.querySelectorAll('.o-toggle-subnav-container') || []).forEach(element => {
            element.classList.remove('u-disable-animation');
        });
    }, 500);
});