import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

document.addEventListener('DOMContentLoaded', () => {
    Alpine.data('navigation', () => ({
        mobileMenu: false
    }));
    
    Alpine.start();
});
