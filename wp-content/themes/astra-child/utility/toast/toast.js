const toast = (() => {
    // Return the main toast function
    return ({
        title = '',
        message = '',
        type = 'info',
        duration = 3000,
        position = 'top-right'
    }) => {
        // Create elements using document fragment for better performance
        const fragment = document.createDocumentFragment();
        const popup = document.createElement('div');
        
        // Add all classes in one operation
        popup.className = `popup ${type} ${position}`;
        
        // Use template literal only if both title and message exist
        popup.innerHTML = `
            ${title ? `<div class="popup-title">${title}</div>` : ''}
            ${message ? `<div class="popup-message">${message}</div>` : ''}
        `.trim();
        
        // Use fragment for better performance
        fragment.appendChild(popup);
        document.body.appendChild(fragment);
        
        // Cleanup function
        const removeToast = () => {
            popup.classList.add('slide-out');
            popup.addEventListener('animationend', () => {
                popup.remove();
            }, { once: true });
        };

        // Auto-remove after duration
        if (duration) {
            setTimeout(removeToast, duration);
        }
        
        // Return control methods
        return {
            remove: removeToast,
            element: popup
        };
    };
})();

