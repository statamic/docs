// Initialize collapse-nav to 'no' if it hasn't been set yet
if (!localStorage.getItem('collapse-nav')) {
    localStorage.setItem('collapse-nav', 'no');
    console.log('not set yet');
}

Array.from(document.querySelectorAll('.js__expand-collapse-nav') || []).forEach(element => {
    element.onclick = function(){
        // Toggle the collapse-nav state between 'yes' and 'no'
        const isCurrentlyCollapsed = localStorage.getItem('collapse-nav');
        const newCollapseState = isCurrentlyCollapsed === 'no' ? 'yes' : 'no';
        localStorage.setItem('collapse-nav', newCollapseState);
        if (localStorage.getItem('collapse-nav') === 'yes') {
            document.querySelectorAll('.o-toggle-subnav input').forEach(element => {
                if (!element.closest('.o-current-menu-item')) {
                    element.checked = false;
                }
            });
            console.log('not collapsed');
        } else {
            document.querySelectorAll('.o-toggle-subnav input').forEach(element => {
                if (!element.closest('.o-current-menu-item')) {
                    element.checked = true;
                }
            });
            console.log('collapsed');
        }
    }
});

