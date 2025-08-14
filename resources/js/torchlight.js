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
        <svg xmlns="http://www.w3.org/2000/svg" class="copy-icon" fill="none" viewBox="0 0 14 14" id="Copy-Document--Streamline-Flex"><desc>Copy Document Streamline Icon: https://streamlinehq.com</desc><g id="copy-document"><path id="Intersect" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M13.3972 11.8956c0.0674 -1.0961 0.1028 -2.23187 0.1028 -3.3956 0 -0.47148 -0.0058 -0.93836 -0.0172 -1.39988 -0.0081 -0.32662 -0.1121 -0.64405 -0.3019 -0.90741 -0.7183 -0.99637 -1.2911 -1.61653 -2.2338 -2.35786 -0.261 -0.20524 -0.5814 -0.31656 -0.911 -0.32388C9.70816 3.5037 9.36573 3.5 9 3.5c-1.10726 0 -2.00102 0.03388 -2.92518 0.09844 -0.79274 0.05538 -1.42235 0.69819 -1.47201 1.50593C4.53542 6.20051 4.5 7.33627 4.5 8.5c0 1.16373 0.03542 2.2995 0.10281 3.3956 0.04966 0.8078 0.67927 1.4506 1.47201 1.506C6.99898 13.4661 7.89274 13.5 9 13.5c1.1073 0 2.001 -0.0339 2.9252 -0.0984 0.7927 -0.0554 1.4223 -0.6982 1.472 -1.506Z" stroke-width="1"/><path id="Intersect_2" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M5 0.5c0.03142 0 0.06267 0.000027 0.09375 0.000082 0.33071 0.000579 0.64258 0.004239 0.94234 0.010891 0.32965 0.007315 0.64999 0.118641 0.91098 0.323877 0.31142 0.24488 0.58247 0.47654 0.83172 0.71291m-7.175983 0.55661C0.652466 1.29663 1.28208 0.653823 2.07482 0.598441c0.04794 -0.003348 0.09579 -0.006614 0.14359 -0.009798M0.602808 8.89563c0.049659 0.80774 0.679272 1.45057 1.472012 1.50597 0.08403 0.0058 0.16781 0.0114 0.25153 0.0168M0.5 5.5c0 -0.31959 0.002671 -0.63708 0.007942 -0.95221V6.4522C0.502671 6.13707 0.5 5.81959 0.5 5.5Z" stroke-width="1"/></g></svg>

        <svg xmlns="http://www.w3.org/2000/svg" class="check-icon" fill="none" viewBox="0 0 14 14" id="Clipboard-Check--Streamline-Flex"><desc>Clipboard Check Streamline Icon: https://streamlinehq.com</desc><g id="clipboard-check--checkmark-edit-task-edition-checklist-check-success-clipboard-form"><path id="Subtract" stroke="currentColor" d="M4.17349 2.10889c-0.25729 0.02946 -0.60252 0.06018 -0.85608 0.09067 -0.24071 0.02894 -0.47967 0.05767 -0.71681 0.08492 -0.49602 0.05701 -0.88913 0.44564 -0.92587 0.93465 -0.23427 3.11835 -0.23427 6.06189 0 9.18027 0.03674 0.489 0.43009 0.8788 0.92783 0.9188 3.02054 0.2425 5.77459 0.2425 8.79514 0 0.4977 -0.04 0.8911 -0.4298 0.9278 -0.9188 0.2343 -3.11838 0.2343 -6.06192 0 -9.18027 -0.0367 -0.48901 -0.4298 -0.87764 -0.9259 -0.93465 -0.2371 -0.02725 -0.4761 -0.05598 -0.7168 -0.08492 -0.2535 -0.03049 -0.6081 -0.06121 -0.86532 -0.09067" stroke-width="1"/><path id="Union" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M8.3045 0.54519c0.97879 0.037253 1.52665 0.52425 1.52665 1.36417 0 0.83991 -0.54786 1.3269 -1.52665 1.36416 -1.58314 0.06025 -1.02528 0.06025 -2.60842 0 -0.97879 -0.03726 -1.52665 -0.52425 -1.52665 -1.36416 0 -0.83992 0.54786 -1.326918 1.52665 -1.36417 1.58314 -0.060253 1.02528 -0.060253 2.60842 0Z" stroke-width="1"/><path id="Vector" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="m4.75 9.17822 1.63636 1.68748C7.15637 8.65381 7.79765 7.6832 9.25 6.36572" stroke-width="1"/></g></svg>

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