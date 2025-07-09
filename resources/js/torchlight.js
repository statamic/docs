// Add language badges and copy buttons to Torchlight code blocks
Array.prototype.forEach.call(document.querySelectorAll('code.torchlight'), function (el) {
    // Add language badge
    if (el.dataset.lang) {
        let badge = document.createElement('div');
        badge.className = 'language-badge';
        badge.innerHTML = el.dataset.lang === 'md' ? 'markdown' : el.dataset.lang;
        el.parentElement.appendChild(badge);
    }
    
    // Add copy button
    let copyButton = document.createElement('button');
    copyButton.className = 'copy-button';
    copyButton.innerHTML = `
        <svg class="copy-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
            <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
        </svg>
        <svg class="check-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="20,6 9,17 4,12"></polyline>
        </svg>
        <span class="copy-text">Copy</span>
    `;
    
    // Position the copy button
    copyButton.style.opacity = '0';
    
    // Show button on hover
    el.parentElement.addEventListener('mouseenter', function() {
        copyButton.style.opacity = '1';
    });
    
    el.parentElement.addEventListener('mouseleave', function() {
        copyButton.style.opacity = '0';
    });
    
    // Copy functionality
    copyButton.addEventListener('click', function() {
        // Get the text content without line numbers and other elements
        let textToCopy = '';
        const lines = el.querySelectorAll('.line');
        
        lines.forEach(line => {
            // Remove line numbers and other non-code elements
            const lineContent = line.cloneNode(true);
            const lineNumbers = lineContent.querySelectorAll('.line-number, .summary-caret, .summary-caret-start, .summary-caret-end, .summary-caret-middle, .summary-caret-empty');
            lineNumbers.forEach(num => num.remove());
            
            // Get the text content and add a newline
            textToCopy += lineContent.textContent + '\n';
        });
        
        // Remove trailing newline
        textToCopy = textToCopy.trim();
        
        // Copy to clipboard
        navigator.clipboard.writeText(textToCopy).then(function() {
            // Show success state
            copyButton.classList.add('copied');
            copyButton.querySelector('.copy-text').textContent = 'Copied!';
            
            // Reset after 2 seconds
            setTimeout(function() {
                copyButton.classList.remove('copied');
                copyButton.querySelector('.copy-text').textContent = 'Copy';
            }, 2000);
        }).catch(function(err) {
            console.error('Failed to copy: ', err);
            // Fallback for older browsers
            const textArea = document.createElement('textarea');
            textArea.value = textToCopy;
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand('copy');
            document.body.removeChild(textArea);
            
            // Show success state
            copyButton.classList.add('copied');
            copyButton.querySelector('.copy-text').textContent = 'Copied!';
            
            setTimeout(function() {
                copyButton.classList.remove('copied');
                copyButton.querySelector('.copy-text').textContent = 'Copy';
            }, 2000);
        });
    });
    
    // Add the copy button to the code block
    el.parentElement.appendChild(copyButton);
});