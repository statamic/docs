// Initialize collapse-nav to 'no' if it hasn't been set yet
if (!localStorage.getItem('collapse-nav')) {
    localStorage.setItem('collapse-nav', 'no');
}

// Function to handle navigation collapse/expand
function toggleNavigation() {
    // Toggle the collapse-nav state between 'yes' and 'no'
    const isCurrentlyCollapsed = localStorage.getItem('collapse-nav');
    const newCollapseState = isCurrentlyCollapsed === 'no' ? 'yes' : 'no';
    localStorage.setItem('collapse-nav', newCollapseState);
    
    if (localStorage.getItem('collapse-nav') === 'yes') {
        document.querySelectorAll('.o-toggle-subnav').forEach(element => {
            if (!element.matches(':has(+ ul .o-current-menu-item)')) {
                element.querySelector('input').checked = false;
            }
        });
        console.log('not collapsed');
    } else {
        document.querySelectorAll('.o-toggle-subnav').forEach(element => {
            if (!element.matches(':has(+ ul .o-current-menu-item)')) {
                element.querySelector('input').checked = true;
            }
        });
        console.log('collapsed');
    }
}

Array.from(document.querySelectorAll('.js__expand-collapse-nav') || []).forEach(element => {
    element.onclick = toggleNavigation;
});

