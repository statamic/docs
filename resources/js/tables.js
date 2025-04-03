document.addEventListener('DOMContentLoaded', function() {
    // Wrap tables in div with c-table class
    const tables = document.querySelectorAll('.c-entry-content table');
    tables.forEach(table => {
        const wrapper = document.createElement('div');
        wrapper.className = 'c-table';
        table.parentNode.insertBefore(wrapper, table);
        wrapper.appendChild(table);
    });
});
